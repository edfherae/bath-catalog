import { Controller } from '@hotwired/stimulus';

export default class extends Controller<HTMLFormElement> {
    private readonly DELAY = 400;
    private timer: number | null = null;

    submitWithDelay() {
        if(this.timer !== null) clearTimeout(this.timer);
        
        this.timer = setTimeout(() => {
            this.element.requestSubmit();
        }, this.DELAY);
    }
    submitImmediately() {
        if(this.timer !== null) {
            clearTimeout(this.timer);
            this.timer = null;
        } 
        this.element.requestSubmit();
    }
    disconnect(): void {
        if(this.timer !== null) clearTimeout(this.timer);
    }
}
