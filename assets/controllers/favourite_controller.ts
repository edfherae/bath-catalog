import { Controller } from "@hotwired/stimulus"

export default class extends Controller<HTMLFormElement> {
    connect(): void {
        this.element.addEventListener("turbo:submit-start", this.onStart);
        this.element.addEventListener("turbo:submit-end", this.onEnd);
    }
    disconnect(): void {
        this.element.removeEventListener("turbo:submit-start", this.onStart);
        this.element.removeEventListener("turbo:submit-end", this.onEnd);
    }
    onStart = () => {
        this.lockAll(true);
    }
    onEnd = () => {
        this.lockAll(false);
    }
    private lockAll(isRequestActive : boolean): void {
        let buttons = document.querySelectorAll<HTMLButtonElement>(".favourite-button");
        buttons.forEach(button => {
            button.disabled = isRequestActive;
            button.classList.toggle("favourite-button--disabled", isRequestActive);
        })
    }
}