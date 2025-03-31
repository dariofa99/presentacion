<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat en Vivo') }}
        </h2>
    </x-slot>

    <input type="text" id="user_id" value="{{ auth()->user()->id }}" hidden>
    <input type="text" id="user_name" value="{{ auth()->user()->name }}" hidden>
    <div class="flex max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-6 h-[500px]">
        <!-- Panel lateral de usuarios -->
        <div class="w-1/4 bg-gray-200 p-4 overflow-y-auto">
            <h3 class="text-lg font-semibold mb-2">Usuarios en línea</h3>
            <ul id="user-list" class="space-y-2">
                <!-- Usuarios conectados dinámicamente -->
            </ul>
        </div>

        <!-- Contenedor del chat -->
        <div class="w-3/4 flex flex-col">
            <!-- Header -->
            <div class="bg-indigo-600 text-white py-3 text-center text-lg font-bold">Chat en Vivo</div>

            <!-- Mensajes -->
            <div id="chat-box" class="p-4 h-80 overflow-y-auto space-y-3 bg-gray-100 flex flex-col">
                <!-- Aquí se agregarán los mensajes dinámicamente -->
            </div>

            <!-- Input de mensaje -->
            <div class="p-3 bg-white flex border-t">
                <input type="text" id="message" placeholder="Escribe un mensaje..."
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                <button onclick="sendMessage()"
                    class="ml-3 bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition">
                    ➤
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userId = document.getElementById('user_id').value;
        console.log("Cargando Laravel Echo...");


        console.log('Laravel Echo cargado:', window.Echo);
        var usersL = []; // Aquí puedes agregar los usuarios dinámicamente desde Laravel


        window.Echo.join('test-channel')
            .here(users => {
                // console.log('Usuarios en el canal:', users)
                usersL = users
                listar()
            })
            .joining(user => {
                //console.log('Usuario se unió:', user)
                usersL.push(user)
                listar()
            })
            .leaving(user => {
                // console.log('Usuario salió:', user)
                usersL = usersL.filter(u => u.id !== user.id);
                listar()
            })
            .error(error => console.error('❌ Error en la suscripción:', error));

        function listar() {
            const userList = document.getElementById('user-list');
            userList.innerHTML = ''; // Limpiar la lista antes de agregar nuevos usuarios
            var userId = document.getElementById('user_id').value;
           
            usersL.forEach(user => {
                const li = document.createElement('li');
                li.className = "p-2 bg-white rounded shadow text-sm";
                li.innerText = (user.id == userId) ? ""+user.name+" (Yo)" : user.name;
                userList.appendChild(li);
            });
        }
        const chatBox = document.getElementById('chat-box');
        window.Echo.private('chat-channel')
            .listen('.Chat', (data) => {
                var id = document.querySelector(
                    `#data_${data.message.id}`) // document.getElementById('data_'+data.message.id);
                if (userId != data.message.user.id) {
                    const chatBox = document.getElementById('chat-box');
                    const dataM = {
                        id: 00,
                        user_name: data.message.user.name,
                        user_id: data.message.user.id,
                        user: data.message.user, // Simulación hasta recibir respuesta
                        message: data.message.message,
                        created_at: new Date().toISOString()
                    };
                    const messageElement = createMessageElement(dataM);
                    chatBox.appendChild(messageElement);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });


        fetchMessages()



    })

    function sendMessage() {
        const message = document.getElementById('message').value;
        if (message.trim() === '') return;
        const messageInput = document.getElementById('message');


        const chatBox = document.getElementById('chat-box');

        if (message === '') return;
        // Crear mensaje en la UI antes de enviarlo al servidor
        //document.getElementById("message").value = "";
        const userId = document.getElementById('user_id').value;
        const tempMessage = createMessageElement({
            id: 00,
            user_name: document.getElementById('user_name').value,
            user_id: userId,
            user: userId, // Simulación hasta recibir respuesta
            message: document.getElementById("message").value,
            created_at: new Date().toISOString()
        });
        document.getElementById("message").value = ""; // Limpiar el campo de entrada
        chatBox.appendChild(tempMessage);
        chatBox.scrollTop = chatBox.scrollHeight;
        axios.post('/messages', {
                message
            })
            .then(response => {
                // console.log('Mensajes obtenidos:', response.data);

            });
    }

    function fetchMessages() {
        axios.get('/messages')
            .then(response => {

                mostrarMensajes(response.data);
            })
            .catch(error => {
                console.error('Error obteniendo mensajes:', error);
            });
    }

    function mostrarMensajes(messages) {
        const chatBox = document.getElementById('chat-box');
        chatBox.innerHTML = ''; // Limpia el chat antes de mostrar nuevos mensajes

        messages.forEach(data => {
            // console.log(data);
            const tempMessage = createMessageElement({
                id: data.id,
                user_name: data.user.name,
                user_id: data.user.id,
                user: data.user, // Simulación hasta recibir respuesta
                message: data.message,
                created_at: data.created_at
            });

            chatBox.appendChild(tempMessage);
            chatBox.scrollTop = chatBox.scrollHeight;
        });


    }


    function createMessageElement(data) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('p-2', 'rounded-lg', 'mb-2', 'chat-message');
        messageElement.setAttribute('id', "data_" + data.id); // Agregar ID al elemento
        var userId = document.getElementById('user_id').value;

        if (data.user_id == userId) {
            var userlbl = "Yo"
            messageElement.classList.add('sent');
        } else {
            var userlbl = data.user_name
            messageElement.classList.add('received');
        }

        messageElement.innerHTML = `
        <strong>${userlbl}:</strong> ${data.message}
        <span class="chat-time">${new Date(data.created_at).toLocaleTimeString()}</span>
    `;

        return messageElement;
    }
</script>
