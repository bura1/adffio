import { Controller } from '@hotwired/stimulus';
import Swal from 'sweetalert2';

export default class extends Controller {
    static targets = ['id']

    delete() {
        console.log(this.idTarget.innerHTML);
    }
}