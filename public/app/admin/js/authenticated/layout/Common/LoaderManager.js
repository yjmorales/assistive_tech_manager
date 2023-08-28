'use strict';

/**
 * Manages the loaders.
 */
function LoaderManager() {
    /**
     * Holds the loaders modules
     * @type {Object}
     */
    const modules = {
        OverlayLoaderManager: new OverlayLoaderManager(),
    }


    /**
     * Starts the dot loader.
     * @return {void}
     */
    function startOverlay() {
        modules.OverlayLoaderManager.start();
    }

    /**
     * Stops the dot loader.
     * @return {void}
     */
    function stopOverlay() {
        modules.OverlayLoaderManager.stop();
    }

    this.startOverlay = startOverlay;
    this.stopOverlay = stopOverlay;
}