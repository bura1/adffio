import { Controller } from '@hotwired/stimulus';
import Swal from 'sweetalert2';

export default class extends Controller {
    static targets = ['id', 'name'];

    delete() {
        Swal.fire({
            title: 'Delete ' + this.nameTarget.innerText + '!',
            html: 'Do you want to delete <strong>' + this.nameTarget.innerText + '</strong> Ad?',
            icon: 'question',
            confirmButtonText: 'Delete',
            showCloseButton: true,
            preConfirm: () => {
                return fetch('/delete-ad/' + this.idTarget.innerText, {
                    method: 'POST'
                }).then((response) => {
                    if (!response.ok) {
                        Swal.fire({
                            icon: 'error',
                            html: 'Failed!'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            html: 'Successfully deleted <strong>' + this.nameTarget.innerText + '</strong> ad!',
                        }).then(function() {
                            location.reload();
                        });
                    }
                })
            }
        })
    }

    activate() {
        Swal.fire({
            title: 'Activate ' + this.nameTarget.innerText + '!',
            html: 'Do you want to activate <strong>' + this.nameTarget.innerText + '</strong> Ad? Other ad will be deactivated.',
            icon: 'question',
            confirmButtonText: 'Activate',
            showCloseButton: true,
            preConfirm: () => {
                return fetch('/activate-ad/' + this.idTarget.innerText, {
                    method: 'POST'
                }).then((response) => {
                    if (!response.ok) {
                        Swal.fire({
                            icon: 'error',
                            html: 'Failed!'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            html: 'Successfully activated <strong>' + this.nameTarget.innerText + '</strong> ad!',
                        }).then(function() {
                            location.reload();
                        });
                    }
                })
            }
        })
    }
}