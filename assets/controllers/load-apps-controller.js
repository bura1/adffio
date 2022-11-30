// import { Controller } from '@hotwired/stimulus';
//
// /* stimulusFetch: 'lazy' */
// export default class extends Controller {
//     static targets = ['output']
//
//     async connect() {
//         await fetch('/get-apps')
//             .then(response => response.json())
//             .then(json => this.setApps(json));
//     }
//
//     setApps(json) {
//         this.outputTarget.textContent = json;
//     }
// }