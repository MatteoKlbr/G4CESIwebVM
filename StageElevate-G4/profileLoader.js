function loadProfile() {
    fetch('profile.php?ajax=1')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur de chargement du profil');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('profile-container').innerHTML = html;
        })
        .catch(error => {
            console.error('Erreur :', error);
            document.getElementById('profile-container').innerHTML = '<p>Erreur lors du chargement du profil.</p>';
        });
}
