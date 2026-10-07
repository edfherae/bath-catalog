import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ['overlay', 'content'];
    
    declare readonly overlayTarget: HTMLElement;
    declare readonly contentTarget: HTMLElement;

    public close() {
        this.clearModal();
    }
    public closeOnOverlay(e : Event) {
        if(e.target === this.overlayTarget) this.clearModal();
    }
    public clearModal() {
        this.element.innerHTML = '';
    }
}