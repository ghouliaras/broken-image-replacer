(function(){
    function replaceWithPlaceholder(img){
        if (!img || img.dataset.birReplaced === '1') return;
        img.dataset.birReplaced = '1';
        if (typeof BIR_DATA !== 'undefined' && BIR_DATA.placeholderUrl) {
            img.srcset = '';
            img.sizes = '';
            img.removeAttribute('srcset');
            img.removeAttribute('sizes');
            img.src = BIR_DATA.placeholderUrl;
            img.classList.add('bir-placeholder');
            // Prevent infinite loop if placeholder fails (rare)
            img.onerror = null;
        }
    }

    function attachHandler(img){
        if (!img || img.dataset.birAttached === '1' || img.hasAttribute('data-bir-ignore')) return;
        img.dataset.birAttached = '1';
        img.addEventListener('error', function(){ replaceWithPlaceholder(img); }, { once: true });
        // If already "broken" when DOM ready (e.g. bad cached entry), check after a tick
        if (img.complete && img.naturalWidth === 0) {
            replaceWithPlaceholder(img);
        }
    }

    function scan(root){
        var imgs = (root || document).getElementsByTagName('img');
        for (var i=0; i<imgs.length; i++) attachHandler(imgs[i]);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function(){ scan(document); });
    } else {
        scan(document);
    }

    // Watch for dynamically added images
    var mo = new MutationObserver(function(mutations){
        mutations.forEach(function(m){
            for (var i=0; i<m.addedNodes.length; i++) {
                var node = m.addedNodes[i];
                if (node.nodeType === 1) {
                    if (node.tagName === 'IMG') {
                        attachHandler(node);
                    } else {
                        scan(node);
                    }
                }
            }
        });
    });
    mo.observe(document.documentElement, { childList: true, subtree: true });
})();
