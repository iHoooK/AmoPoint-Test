(function () {
    var currentScript = document.currentScript;

    if (!currentScript) {
        return;
    }

    var endpoint = currentScript.getAttribute('data-endpoint');
    var siteKey = currentScript.getAttribute('data-site-key');
    var requireConsent = currentScript.getAttribute('data-require-consent') === 'true';
    var consentKey = currentScript.getAttribute('data-consent-key') || 'amopoint_tracking_consent';

    if (!endpoint || !siteKey) {
        return;
    }

    if (requireConsent && localStorage.getItem(consentKey) !== 'accepted') {
        return;
    }

    var clientIdKey = 'amopoint_tracker_client_id';
    var clientId = localStorage.getItem(clientIdKey);

    if (!clientId && window.crypto && typeof window.crypto.randomUUID === 'function') {
        clientId = window.crypto.randomUUID();
        localStorage.setItem(clientIdKey, clientId);
    }

    if (!clientId) {
        clientId = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (character) {
            var random = Math.random() * 16 | 0;
            var value = character === 'x' ? random : (random & 0x3 | 0x8);

            return value.toString(16);
        });

        localStorage.setItem(clientIdKey, clientId);
    }

    function detectDeviceType() {
        var userAgent = navigator.userAgent.toLowerCase();

        if (/tablet|ipad/.test(userAgent)) {
            return 'tablet';
        }

        if (/mobi|android|iphone/.test(userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    function detectBrowser() {
        var userAgent = navigator.userAgent;

        if (/Edg\//.test(userAgent)) {
            return 'Edge';
        }

        if (/Chrome\//.test(userAgent) && !/Edg\//.test(userAgent)) {
            return 'Chrome';
        }

        if (/Firefox\//.test(userAgent)) {
            return 'Firefox';
        }

        if (/Safari\//.test(userAgent) && !/Chrome\//.test(userAgent)) {
            return 'Safari';
        }

        if (/OPR\//.test(userAgent)) {
            return 'Opera';
        }

        return 'Unknown';
    }

    function detectPlatform() {
        var userAgent = navigator.userAgent;

        if (/Windows/.test(userAgent)) {
            return 'Windows';
        }

        if (/Mac OS X/.test(userAgent)) {
            return 'macOS';
        }

        if (/Android/.test(userAgent)) {
            return 'Android';
        }

        if (/iPhone|iPad|iPod/.test(userAgent)) {
            return 'iOS';
        }

        if (/Linux/.test(userAgent)) {
            return 'Linux';
        }

        return 'Unknown';
    }

    var payload = new URLSearchParams({
        client_id: clientId,
        site_key: siteKey,
        page_url: window.location.href,
        referrer: document.referrer || '',
        device_type: detectDeviceType(),
        browser: detectBrowser(),
        platform: detectPlatform(),
        user_agent: navigator.userAgent,
        language: navigator.language || '',
        screen_width: String(window.screen.width || 0),
        screen_height: String(window.screen.height || 0),
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone || '',
    });

    function sendVisit() {
        if (navigator.sendBeacon) {
            navigator.sendBeacon(endpoint, payload);

            return;
        }

        fetch(endpoint, {
            method: 'POST',
            mode: 'cors',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
            },
            body: payload.toString(),
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', sendVisit, { once: true });
    } else {
        sendVisit();
    }
}());
