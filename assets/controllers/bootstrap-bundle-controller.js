import { Controller } from "@hotwired/stimulus";
import * as bootstrap from 'bootstrap';

export default class extends Controller {

    async connect() {
        window.bootstrap = bootstrap;
        if(bootstrap !== null){
            console.log(bootstrap);
        }
        console.log("bootstrap not supported");
    }
}