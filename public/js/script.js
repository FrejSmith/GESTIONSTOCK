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
});