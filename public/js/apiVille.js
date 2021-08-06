const url = 'https://geo.api.gouv.fr/communes/?codePostal='
let codePostal = '';
fetch(url)
    .then(function (response) { return response.json(); })
    .then(function (data) {
        console.log(data);
    })
    .catch(function (e) { return console.log("erreur : " + e); });

console.log('test');
console.log(document.getElementById('ville_nom'));
