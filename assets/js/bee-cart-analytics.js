jQuery(document).ready(function ($) {
  // Simple analytics logging for abandon cart event checking
  // We'll log a "cart_viewed" event.
  // The rest (creation, checkout) are handled in PHP hooked to WC hooks.

  function logEvent(eventType) {
    if (typeof beeCartAnalytics === "undefined") return;
    $.ajax({
      url: beeCartAnalytics.ajax_url,
      type: "POST",
      data: {
        action: "beecart_log_event",
        event_type: eventType,
        security: beeCartAnalytics.nonce,
      },
    });
  }

  // Trigger view log once on load with simple delay so it doesnt slow down rendering
  setTimeout(function () {
    logEvent("page_view");
  }, 2000);

  // Optionally we can log when they open the cart exactly
  $(document).on(
    "click",
    ".cart-contents, .header-cart, [data-close-bee-cart], .bee-add-to-cart-btn",
    function () {
      clearTimeout(window.beeCartTrackTimer);
      window.beeCartTrackTimer = setTimeout(function () {
        logEvent("cart_interacted");
      }, 1000);
    },
  );
});
