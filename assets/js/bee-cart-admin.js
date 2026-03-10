document.addEventListener("alpine:init", () => {
  Alpine.store("admin", {
    activeTab: "placement",

    setTab(tab) {
      this.activeTab = tab;
    },
  });

  Alpine.data("colorPicker", (initialValue) => ({
    color: initialValue,
    isValid: true,

    updatePicker(e) {
      this.color = e.target.value.toUpperCase();
      this.isValid = true;
    },

    updateInput(e) {
      let val = e.target.value.toUpperCase();
      if (val && !val.startsWith("#") && val.length > 0) {
        val = "#" + val;
      }
      this.color = val;
      const regex = /^#[0-9A-Fa-f]{6}$/;
      this.isValid = regex.test(val);
    },
  }));

  // Handle Save Settings
  jQuery(document).on("click", "#bee-save-settings", function (e) {
    const $btn = jQuery(this);
    const originalText = $btn.text();
    $btn.text("Saving...").prop("disabled", true);

    const settings = {};

    // Helper to set nested value
    const setNestedValue = (obj, path, value) => {
      const keys = path.split(/[\[\]]+/).filter((k) => k);
      let current = obj;
      for (let i = 0; i < keys.length; i++) {
        const key = keys[i];
        if (i === keys.length - 1) {
          current[key] = value;
        } else {
          current[key] = current[key] || (isNaN(keys[i + 1]) ? {} : []);
          current = current[key];
        }
      }
    };

    // Collect all inputs, selects, and textareas
    jQuery(
      '.tab-pane input, .tab-pane select, .tab-pane textarea, input[name^="goals"]',
    ).each(function () {
      const $el = jQuery(this);
      const name = $el.attr("name");

      if (!name) return;

      let value;
      if ($el.is(":checkbox")) {
        value = $el.is(":checked");
      } else if ($el.is(":radio")) {
        if (!$el.is(":checked")) return;
        value = $el.val();
      } else {
        value = $el.val();
      }

      setNestedValue(settings, name, value);
    });

    jQuery.ajax({
      url: beeCartAdminData.ajax_url,
      type: "POST",
      data: {
        action: "beecart_save_settings",
        security: beeCartAdminData.nonce,
        settings: JSON.stringify(settings),
      },
      success: function (response) {
        if (response.success) {
          alert(response.data);
          window.location.reload(); // Reload to reflect changes in preview
        } else {
          alert("Error: " + response.data);
        }
      },
      error: function () {
        alert("An error occurred while saving.");
      },
      complete: function () {
        $btn.text(originalText).prop("disabled", false);
      },
    });
  });
});
