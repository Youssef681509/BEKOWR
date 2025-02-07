import { Controller } from "@hotwired/stimulus";
import $ from 'jquery'

export default class extends Controller {
    static targets = ["showData"];

    static values = {
        url: String,
    };

    // initialize() {
    //     super.initialize();
    //     this.load();
    // }

    async connect() {
        this.load();
    }

     load(){
        $.get(this.urlValue, (response) => {
            $(this.showDataTarget).html(response);
        }).fail(() => {
            alert('Une erreur est survenu l\'ors du traitement de la requêtes');
        })
    }

    async navigate(event){
        event.preventDefault();
        // on récupère l'url du lien
        const url = event.currentTarget.href;
        // puis on éxecute une requête ajax
        $.get(url, (response) => {
            $(this.showDataTarget).html(response);
        }).fail(() => {
            alert('Une erreur est survenu l\'ors du traitement de la requêtes');
        });
    }
}
