import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['name', 'output']

    greet() {
        this.outputTarget.textContent = `Hello, ${this.nameTarget.value}!`
    }
}
