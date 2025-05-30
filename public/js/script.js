document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#inventory-table table');
    if (table) {
        console.log('Tableau chargé :', table);
        // Exemple : Ajouter une couleur de fond sur hover
        table.addEventListener('mouseover', (event) => {
            if (event.target.tagName === 'TD') {
                event.target.style.backgroundColor = '#f0f0f0';
            }
        });

        table.addEventListener('mouseout', (event) => {
            if (event.target.tagName === 'TD') {
                event.target.style.backgroundColor = '';
            }
        });
    }

    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        row.addEventListener('mouseover', () => {
            row.style.backgroundColor = '#d3eaf7';
        });

        row.addEventListener('mouseout', () => {
            row.style.backgroundColor = '';
        });
    });

    // Exemple : Afficher une alerte après l'enregistrement
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', () => {
            alert('Transaction enregistrée avec succès !');
        });
    }

    const carouselSlide = document.querySelector('.carousel-slide');
    const images = document.querySelectorAll('.carousel-slide img');

    let counter = 0;
    const size = images[0].clientWidth;

    function moveCarousel() {
        counter++;
        if (counter >= images.length) {
            counter = 0;
        }
        carouselSlide.style.transform = `translateX(${-counter * size}px)`;
    }

    setInterval(moveCarousel, 3000); // Change d'image toutes les 3 secondes

    const featureBoxes = document.querySelectorAll('.feature-box');

    featureBoxes.forEach(box => {
        box.addEventListener('mouseover', () => {
            box.style.backgroundColor = '#eaf4fc';
        });

        box.addEventListener('mouseout', () => {
            box.style.backgroundColor = 'white';
        });
    });
});