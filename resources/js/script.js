// Carosello immagini pagina dettaglio articolo
function changeSlide(direction) {
    const images = document.querySelectorAll('.article-carousel-img');
    if (!images.length) return;

    // Trova l'immagine attiva
    let currentIndex = [...images].findIndex(img => img.classList.contains('active'));

    // Rimuove active dall'immagine corrente
    images[currentIndex].classList.remove('active');

    // Calcola il nuovo indice in modo circolare
    currentIndex = (currentIndex + direction + images.length) % images.length;

    // Aggiunge active alla nuova immagine
    images[currentIndex].classList.add('active');
}

// # Script per nascondere il messaggio dopo 5 secondi

document.addEventListener('DOMContentLoaded', () => {
    // Cerca l'elemento con ID 'flash-message'
    const flashMessage = document.getElementById('flash-message');

    // Se l'elemento esiste in questa pagina, fa partire il timer
    if (flashMessage) {
        setTimeout(() => {
            // Effetto dissolvenza
            flashMessage.style.transition = 'opacity 0.5s ease';
            flashMessage.style.opacity = '0';

            // Rimuove l'elemento dopo la transizione
            setTimeout(() => flashMessage.remove(), 500);
        }, 4000);
    }
});

// # SCRIPT JAVASCRIPT PER GESTIRE I CHECKBOX E IL TOTALE NEL CARRELLO 

// # 1. SELEZIONE DEGLI ELEMENTI HTML
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalDisplay = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');
    const inputsContainer = document.getElementById('selected-items-inputs');

    // # 2. FUNZIONE PRINCIPALE: Ricalcola il totale e prepara i dati
    function updateTotal() {
        let total = 0; 
        let selectedCount = 0; 
        inputsContainer.innerHTML = ''; 

        // # Cicla ogni singolo checkbox presente nella pagina
        checkboxes.forEach(checkbox => {

            // # Se il checkbox attuale ha la spunta (è checked)...
            if (checkbox.checked) {

                // # A) CALCOLO PREZZO
                // # Legge il prezzo e la quantità dagli attributi 'data-price' e 'data-quantity'
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);

                // # Somma al totale il costo (prezzo * quantità)
                total += (price * quantity);
                selectedCount++; // # Aumenta il contatore degli oggetti spuntati

                // # B) PREPARAZIONE DATI PER IL BACKEND
                // # Crea un nuovo elemento HTML di tipo <input>
                const input = document.createElement('input');
                input.type = 'hidden'; 
                input.name = 'selected_items[]'; 
                input.value = checkbox.value; 

                // # Inserisce fisicamente questo nuovo input dentro il form
                inputsContainer.appendChild(input);
            }
        });

        // # 3. AGGIORNAMENTO DELLA GRAFICA
        // # Scrive il nuovo totale sostituendo il punto con la virgola per i decimali
        totalDisplay.textContent = '€' + total.toFixed(2).replace('.', ',');

        // # Se selectedCount è uguale a 0, il bottone rimane disabilitato (true)
        // # Se selectedCount è maggiore di 0, il bottone si abilita (false)
        checkoutBtn.disabled = selectedCount === 0;
    }

    // # 4. ATTIVAZIONE DELLA FUNZIONE
    // # Aggiunge un "ascoltatore di eventi": ogni volta che lo stato di un checkbox cambia ('change'),
    // # esegue automaticamente la funzione updateTotal() per ricalcolare tutto.
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
    });
});