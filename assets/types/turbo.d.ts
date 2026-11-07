declare global {
    interface TurboFormSubmission {
        formElement: HTMLFormElement;
        fetchRequest: {
            headers: Record<string, string>;
        };
        stop(): void;
    }

    interface DocumentEventMap {
        "turbo:submit-start": CustomEvent<{
            formSubmission: TurboFormSubmission;
        }>;
        "turbo:submit-end": CustomEvent<{
            formSubmission: TurboFormSubmission;
            success: boolean;
        }>;
    }
}

export {};
