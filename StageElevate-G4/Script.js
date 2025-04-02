document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Mettre le contenu du champ « Nom » en majuscule après la saisie
    const nomInput = document.getElementById('nom');
    nomInput.addEventListener('input', () => {
        nomInput.value = nomInput.value.toUpperCase();
    });

    // 2. Vérification de l'email avec regex
    const emailInput = document.getElementById('email');
    emailInput.addEventListener('input', () => {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        const emailMessage = document.getElementById('emailMessage');
        if (!emailRegex.test(emailInput.value)) {
            emailMessage.textContent = 'Veuillez entrer un email valide';
            emailMessage.style.color = 'red';
        } else {
            emailMessage.textContent = '';
        }
    });

// 3. Vérification du fichier du CV (format et taille)
document.addEventListener("DOMContentLoaded", function () {
    const cvInput = document.getElementById('cv');
    const cvMessage = document.getElementById('cvMessage');
    const fileNameDisplay = document.getElementById('file-name');
    const allowedTypes = ['pdf', 'doc', 'docx', 'odt', 'rtf', 'jpg', 'png'];
    const maxSize = 2 * 1024 * 1024; // 2 Mo

    cvInput.addEventListener('change', function () {
        const file = cvInput.files[0];

        if (file) {
            const fileType = file.name.split('.').pop().toLowerCase();
            const fileSize = file.size;

            // Vérification du format et de la taille du fichier
            if (!allowedTypes.includes(fileType) || fileSize > maxSize) {
                // Si le fichier est invalide, affiche le message d'erreur
                cvMessage.textContent = 'Format ou taille du fichier invalide. Formats autorisés : .pdf, .doc, .docx, .odt, .rtf, .jpg, .png (max. 2 Mo)';
                cvMessage.style.color = 'red';
                cvInput.value = ''; // Réinitialise l'input
                fileNameDisplay.textContent = 'Aucun fichier sélectionné'; // Réinitialise le nom du fichier
            } else {
                // Si le fichier est valide, affiche son nom
                cvMessage.textContent = ''; // Retirer les messages d'erreur
                fileNameDisplay.textContent = file.name; // Afficher le nom du fichier sélectionné
            }
        } else {
            // Si aucun fichier n'est sélectionné, réinitialise le texte
            fileNameDisplay.textContent = 'Aucun fichier sélectionné';
        }
    });

    // Empêcher la soumission si le fichier est invalide
    document.querySelector('form').addEventListener('submit', function (e) {
        if (!cvInput.files[0] || cvMessage.textContent) {
            e.preventDefault(); // Bloque la soumission
            alert('Veuillez sélectionner un fichier valide avant de soumettre.');
        }
    });
});


    // 4. Vérification des champs obligatoires avant l'envoi du formulaire
    const form = document.getElementById('formPostuler');
    form.addEventListener('submit', (e) => {
        const nom = document.getElementById('nom').value;
        const prenom = document.getElementById('prenom').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        if (!nom || !prenom || !email || !message) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    });

    // 5. Bouton "Revenir en haut" visible lorsqu'on descend dans la page
    const backToTopButton = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 200) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // 6. Menu burger pour la version mobile
    const burgerButton = document.getElementById('burgerButton');
    const mobileMenu = document.getElementById('mobileMenu');

    burgerButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('visible');
    });
});
