// persistedStatePlugin.js

const persistedState = (options) => {
    const key = options.key || 'PersistedState';
    const modulesToPersist = options.modules || [];

    return (store) => {
        // Load state from LocalStorage on store initialization
        const storedState = sessionStorage.getItem(key);
        if (storedState) {
            const parsedState = JSON.parse(storedState);
            store.replaceState({
                ...store.state,
                ...parsedState,
            });
        }

        // Store the list of registered modules
        const registeredModules = [...modulesToPersist];

        // Watch for state changes and persist them to LocalStorage
        store.subscribe((mutation, state) => {
            // Check if the mutation corresponds to any of the modules to persist
            if (modulesToPersist.includes(mutation.type.split('/')[0])) {
                sessionStorage.setItem(key, JSON.stringify(state));
            }
        });

        // Update the list of registered modules when a new module is registered
        store.subscribeAction((action) => {
            if (action.type === 'store/registerModule') {
                const { type, preserveState } = action.payload;
                if (preserveState && !registeredModules.includes(type)) {
                    registeredModules.push(type);
                }
            }
        });

        // Clean up LocalStorage when the store is destroyed
        store.subscribeAction((action) => {
            if (action.type === 'before' && action.payload.type === 'store/unregisterModule') {
                const { moduleName } = action.payload;
                if (modulesToPersist.includes(moduleName)) {
                    sessionStorage.removeItem(key);
                }
            }
        });
    };
};

export default persistedState;
