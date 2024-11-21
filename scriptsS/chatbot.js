document.addEventListener('DOMContentLoaded', function () {
    class Chatbot {
        constructor() {
            this.chatbotIcon = document.getElementById('chatbot-icon');
            this.chatbotContainer = document.getElementById('chatbot-container');
            this.chatMessages = document.getElementById('chat-messages');
            this.closeChatbotBtn = document.getElementById('close-chatbot-btn');
            this.chatInput = document.getElementById('chat-input');
            this.sendBtn = document.getElementById('send-btn');
            this.userName = this.chatbotIcon.getAttribute('data-username') || 'Usuario';
            this.orderItems = []; // Para almacenar los productos seleccionados por el usuario
            this.step = 0; // Para el flujo de preguntas 
            this.address = ''; // Para almacenar la dirección
            this.reservationCount = 0; // Para almacenar el número de personas en la reserva
            this.hasGreeted = false; // Bandera para evitar que se repita el saludo
            this.addEventListeners();
        }

        addEventListeners() {
            this.chatbotIcon.addEventListener('click', () => this.toggleChatbot()); // Al hacer clic en el ícono se abre o cierra el chatbot
            this.chatbotContainer.addEventListener('click', (e) => {
                // Evitar que el clic dentro de las opciones (botones) cierre el chatbot
                if (e.target !== this.chatMessages && e.target.tagName !== 'BUTTON') {
                    this.toggleChatbot(); // Al hacer clic en el contenedor se abre o cierra el chatbot
                }
            });
            this.closeChatbotBtn.addEventListener('click', () => this.closeChatbot()); // Cerrar el chatbot desde el botón
            this.sendBtn.addEventListener('click', () => this.handleSendMessage()); // Enviar mensaje desde el botón
            this.chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.handleSendMessage(); // Enviar mensaje al presionar Enter
            });
            document.addEventListener('click', (e) => this.handleDocumentClick(e)); // Cerrar el chatbot al hacer clic fuera de él
            this.chatMessages.addEventListener('click', (e) => {
                if (e.target.tagName === 'BUTTON') {
                    e.stopPropagation(); // Evita que el evento 'click' llegue al document
                }
            });
        }
        
        
        
        // Función que maneja el clic en el documento
        handleDocumentClick(event) {
            // Verificar si el clic fue fuera del chatbot y el ícono del chatbot
            const isClickInsideChatbot = this.chatbotContainer.contains(event.target) || this.chatbotIcon.contains(event.target);
            
            // Si el clic no fue dentro del chatbot ni del ícono del chatbot, se cierra el chatbot
            if (!isClickInsideChatbot && this.chatbotContainer.classList.contains('open')) {
                this.toggleChatbot(); // Cierra el chatbot
            }
        }        
            
        closeChatbot() {
            this.chatbotContainer.classList.remove('open'); // Usamos la clase 'open' para mostrar/ocultar
            this.clearChat(); // Borra la conversación cuando se cierra el chatbot
            this.hasGreeted = false;
        }
        
        toggleChatbot(isOpen = null) {
            const isCurrentlyOpen = this.chatbotContainer.classList.contains('open');
            
            if (isOpen === null) {
                // Si no se pasa el parámetro, alternamos el estado del chatbot
                this.chatbotContainer.classList.toggle('open');
                
                if (!isCurrentlyOpen && !this.hasGreeted) {
                    this.sendGreeting(); // Solo enviar el saludo si aún no se ha enviado
                }
            } else {
                // Si se pasa el parámetro, forzamos el estado del chatbot (abrir o cerrar)
                if (isOpen) {
                    this.chatbotContainer.classList.add('open');
                    if (!this.hasGreeted) {
                        this.sendGreeting(); // Solo enviar el saludo si aún no se ha enviado
                    }
                } else {
                    this.chatbotContainer.classList.remove('open');
                }
            }
        }
        
        
        sendGreeting() {
            const greetingMessage = `Hola, ${this.userName}, soy Perkins tu camarero virtual. ¿Qué te gustaría hacer hoy?`;
            this.chatMessages.innerHTML += `<p class="bot-message"><strong>Chatbot:</strong> ${greetingMessage}</p>`;
            this.showMainOptions(); // Mostrar las opciones después del saludo
            this.scrollToBottom(); // Desplazar al fondo
        
            // Marcamos que el saludo ya ha sido enviado
            this.hasGreeted = true;
        }
        
        
        clearChat() {
            this.chatMessages.innerHTML = ''; // Borra los mensajes del chat
        }

        handleSendMessage() {
            const message = this.chatInput.value.trim();
            if (message) {
                this.sendMessage(message);
                this.chatInput.value = '';
            }
        }

        sendMessage(message) {
            this.chatMessages.innerHTML += `<p><strong>Tú:</strong> ${message}</p>`;
            this.handleChatResponse(message);
            this.scrollToBottom();
        }

        handleDocumentClick(event) {
            // Verificar si el clic fue fuera del chatbot y del ícono del chatbot
            const isClickInsideChatbot = this.chatbotContainer.contains(event.target) || this.chatbotIcon.contains(event.target);
            
            // Si el clic fue fuera del chatbot y el chatbot está abierto, cerramos el chatbot sin borrar el contenido
            if (!isClickInsideChatbot && this.chatbotContainer.classList.contains('open')) {
                this.toggleChatbot(false); // Cierra el chatbot sin reiniciar el chat
            }
        }
        
        showMainOptions() {
            const options = ['Delivery', 'Comida'];
            this.chatMessages.innerHTML += `<p class="bot-message"><strong>Chatbot:</strong> ¿Qué te gustaría hacer hoy ${this.userName}?</p>`;

            options.forEach(option => {
                const button = document.createElement('button');
                button.innerText = option;
                button.classList.add('option-button');
                button.addEventListener('click', () => {
                    this.handleMainOptionSelection(option);
                });
                this.chatMessages.appendChild(button);
            });

            this.scrollToBottom();
        }

        handleMainOptionSelection(option) {
            this.chatMessages.innerHTML += `<p class="user-message"><strong>Tú:</strong> ${option}</p>`;

            if (option === 'Delivery') {
                this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Perfecto, para realizar un delivery, por favor proporciona tu dirección.</p>`;
                this.scrollToBottom();
                this.collectDeliveryAddress(); // Recolectamos la dirección de entrega
            } else if (option === 'Comida') {
                this.showCategoryButtons(); //  mostramos las categorías de productos
            }
        }

        collectDeliveryAddress() {
            this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Por favor, escribe tu dirección de entrega (ej. Calle Ficticia 123, Ciudad, CP).</p>`;
            this.scrollToBottom();
            this.chatInput.focus();
            this.chatInput.disabled = false;
            this.step = 1; // Avanzamos al siguiente paso
        }

        handleChatResponse(message) {
            if (this.step === 1) {
                // Recolectamos la dirección
                this.address = message;
                this.chatMessages.innerHTML += `<p><strong>Tú:</strong> ${message}</p>`;
                this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Dirección registrada: ${message}. Ahora, elige los productos que te gustaría recibir en tu delivery.</p>`;
                this.orderItems.push({ address: message });
                this.showCategoryButtons(); // Mostrar las categorías de productos
            } else if (this.step === 2) {
                // Recolectamos la cantidad de personas
                const count = parseInt(message.trim());
                if (count > 0) {
                    this.reservationCount = count;
                    this.chatMessages.innerHTML += `<p><strong>Tú:</strong> ${count} personas.</p>`;
                    this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Reserva para ${count} personas realizada. Elige los productos que te gustaría reservar.</p>`;
                    this.orderItems.push({ reservationCount: count });
                    this.showCategoryButtons(); // Mostrar las categorías de productos
                } else {
                    this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Lo siento, por favor ingresa un número válido de personas.</p>`;
                }
            } else {
                this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Lo siento, no entendí tu mensaje ${this.userName}.</p>`;
                this.showMainOptions(); // Mostrar las opciones nuevamente si no entendió el mensaje
            }
            this.scrollToBottom();
        }
        
        showCategoryButtons() {
            const categories = ['sandwich', 'segundos', 'sopas', 'bebidas', 'aperitivos'];
            this.chatMessages.innerHTML += `<p class="bot-message"><strong>Chatbot:</strong> ¿Qué te gustaría comer hoy, ${this.userName}?</p>`;

            categories.forEach(category => {
                const button = document.createElement('button');
                button.innerText = category;
                button.classList.add('category-button');
                button.addEventListener('click', () => {
                    this.handleCategorySelection(category);
                });
                this.chatMessages.appendChild(button);
            });

            this.scrollToBottom();
        }

        handleCategorySelection(category) {
            this.chatMessages.innerHTML += `<p class="user-message"><strong>Tú:</strong> ${category}</p>`;
            this.fetchData('get_products.php', `Productos de ${category}`, category);
        }
        fetchData(endpoint, label, category) {
            const url = `${endpoint}?categoria=${encodeURIComponent(category)}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta de la API:", data); // Verifica la respuesta completa
        
                    if (data.status === "success") {
                        // Mostrar los productos
                        this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> ${label}:</p>`;
        
                        data.products.forEach(product => {
                            // Asegúrate de que cada producto tiene un nombre y un precio
                            if (!product.name || !product.price) {
                                console.error("Producto sin nombre o precio:", product);
                            } else {
                                const button = document.createElement('button');
                                button.innerText = `${product.name} - $${product.price}`;
                                button.classList.add('product-button');
                                button.addEventListener('click', () => {
                                    this.handleProductSelection(product);
                                });
                                this.chatMessages.appendChild(button);
                            }
                        });
                    } else {
                        this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> ${data.message}</p>`;
                    }
        
                    this.scrollToBottom();
                })
                .catch(() => {
                    this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Error al obtener ${label.toLowerCase()}.</p>`;
                    this.scrollToBottom();
                });
        }
        handleProductSelection(product) {
            console.log('Producto seleccionado:', product);
        
            // Asegúrate de que los datos del producto estén correctos
            if (!product.name || !product.price) {
                console.error("Error: El producto seleccionado no tiene nombre o precio");
                return;
            }
        
            // Mostrar el producto seleccionado
            this.chatMessages.innerHTML += `<p><strong>Tú:</strong> ${product.name}</p>`;
            this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Has seleccionado ${product.name}. ¿Quieres algo más o salir?</p>`;
        
            // Añadir el producto seleccionado a 'orderItems'
            this.orderItems.push({
                name: product.name,
                price: product.price,
                category: product.category,
                id: product.id,  // ID del producto, necesario para actualizar el stock
                quantity: 1 // Asumimos que seleccionaron una unidad, puedes agregar una opción para cambiar la cantidad
            });
        
            // Crear los botones "Algo más" y "Salir"
            const buttonMore = document.createElement('button');
            buttonMore.innerText = 'Algo más';
            buttonMore.classList.add('option-button');
            buttonMore.addEventListener('click', () => {
                this.handleMoreSelection(); // Función para seleccionar más productos
            });
        
            const buttonExit = document.createElement('button');
            buttonExit.innerText = 'Salir';
            buttonExit.classList.add('option-button');
            buttonExit.addEventListener('click', () => {
                this.handleExitSelection(); // Función para finalizar la compra
            });
        
            // Añadir los botones al chat
            this.chatMessages.appendChild(buttonMore);
            this.chatMessages.appendChild(buttonExit);
        
            this.scrollToBottom();
        }
        
        // Maneja la opción "Algo más" para permitir al usuario seleccionar más productos
        handleMoreSelection() {
            this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> ¿Qué más te gustaría pedir?</p>`;
            this.showCategoryButtons(); // Mostrar las categorías nuevamente para que el usuario pueda seleccionar más productos
            this.scrollToBottom();
        }
        generateQRCode(orderDetails, totalPrice) {
            const orderDetailsString = encodeURIComponent(JSON.stringify(orderDetails));
            const totalPriceString = encodeURIComponent(totalPrice);
        
            const paymentUrl = `http://192.168.0.14:8000/cafe3.0/pagarP.php?info=${orderDetailsString}&total=${totalPriceString}`;
        
            fetch('genera_qrP.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order_details: orderDetails, total_price: totalPrice })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const qrImage = document.createElement('img');
                    qrImage.src = `data:image/png;base64,${data.qr_image}`;
                    this.chatMessages.appendChild(qrImage);
                    this.scrollToBottom();
        
                    // Aquí es donde agregamos los botones "Hacer algo más" y "Salir"
                    const buttonMore = document.createElement('button');
                    buttonMore.innerText = 'Hacer algo más';
                    buttonMore.classList.add('option-button');
                    buttonMore.addEventListener('click', () => {
                        this.handleMoreSelection(); // Volver a las opciones de Delivery o productos
                    });
        
                    const buttonExit = document.createElement('button');
                    buttonExit.innerText = 'Salir';
                    buttonExit.classList.add('option-button');
                    buttonExit.addEventListener('click', () => {
                        this.closeChatbot(); // Cerrar el chatbot
                    });
        
                    this.chatMessages.appendChild(buttonMore);
                    this.chatMessages.appendChild(buttonExit);
                } else {
                    console.error('Error en la generación del QR:', data.message);
                    this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Error al generar el código QR: ${data.message}</p>`;
                    this.scrollToBottom();
                }
            })
            .catch(error => {
                console.error('Error al generar el QR:', error);
                this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Ocurrió un error al generar el código QR.</p>`;
                this.scrollToBottom();
            });
        }
        
        // Esta función ahora solo se llama después de que se ha generado el QR
        handleExitSelection() {
            this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> Gracias por tu pedido. ¡Te lo traeremos pronto!</p>`;
        
            // Mostrar el resumen del pedido
            let totalPrice = 0;
            let orderSummary = '<p><strong>Resumen de tu pedido:</strong></p>';
        
            this.orderItems.forEach(item => {
                if (typeof item.price === 'undefined' || isNaN(item.price)) {
                    console.error("Error: El precio de un producto es inválido", item);
                } else {
                    orderSummary += `<p>${item.name} - $${item.price}</p>`;
                    totalPrice += parseFloat(item.price);
                }
            });
        
            const deliveryCost = 5; // Ejemplo de costo de delivery
            totalPrice += deliveryCost;
        
            if (isNaN(totalPrice)) {
                totalPrice = 0;
            }
        
            orderSummary += `<p><strong>Total de tu pedido:</strong> $${totalPrice} (incluye $${deliveryCost} de delivery)</p>`;
        
            this.chatMessages.innerHTML += orderSummary;
        
            // Llamar a la función para generar el código QR
            this.generateQRCode(orderSummary, totalPrice);
        
            this.scrollToBottom();
        }
        
        // Esta función permite que el usuario pueda hacer más selecciones (volver al flujo de delivery/productos)
        handleMoreSelection() {
            this.chatMessages.innerHTML += `<p><strong>Chatbot:</strong> ¿Qué más te gustaría pedir?</p>`;
            this.showCategoryButtons(); // Mostrar las categorías de productos, no las opciones de Delivery o Comida
            this.scrollToBottom();
        }  
        
        scrollToBottom() {
            this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
        }
    }
    new Chatbot();
});
