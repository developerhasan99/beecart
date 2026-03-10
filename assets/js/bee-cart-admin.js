document.addEventListener("alpine:init", () => {
  Alpine.store("admin", {
    activeTab: "placement",
    settings: {
      progress_type: "subtotal",
      goals: [
        { threshold: 50, label: "Free Shipping", icon: "truck" },
        { threshold: 100, label: "20% Discount", icon: "tag" },
      ],
      primary_color: "#000000",
      enable_coupon: true,
      enable_badges: true,
      show_rewards_on_empty: true,
      rewards_bar_bg: "#E2E2E2",
      rewards_bar_fg: "#93D3FF",
      rewards_complete_icon_color: "#4D4949",
      rewards_incomplete_icon_color: "#4D4949",
      rewards_completed_text:
        "🎉 Congratulations! You have unlocked all rewards.",
      inherit_fonts: true,
      show_strikethrough: true,
      enable_subtotal_line: true,
      bg_color: "#FFFFFF",
      accent_color: "#f6f6f7",
      text_color: "#000000",
      savings_text_color: "#2ea818",
      btn_radius: "0px",
      btn_color: "#000000",
      btn_text_color: "#FFFFFF",
      btn_hover_color: "#333333",
      btn_hover_text_color: "#e9e9e9",
      cart_icon_type: "bag-1",
      cart_icon_color: "#000000",
      cart_icon_size: "24",
      cart_bubble_bg: "#ff0000",
      cart_bubble_text: "#ffffff",
      show_cart_count: true,
      cart_title: "Your Cart",
      show_close_icon: true,
      show_announcement: false,
      announcement_text: "Your products are reserved for {timer}!",
      announcement_bg: "#000000",
      announcement_text_color: "#ffffff",
      announcement_font_size: "13px",
      enable_timer: false,
      timer_duration: "0",
      show_item_images: true,
      show_item_total: true,
      show_upsells: true,
      upsell_title: "Complete your look",
      upsell_max: 3,
      show_trust_badges: true,
      trust_badges_title: "Secure Checkout",
      selected_badges: ["visa", "mastercard", "paypal", "apple-pay"],
      ...(Array.isArray(beeCartAdminData.settings)
        ? {}
        : beeCartAdminData.settings),
    },
    isSaving: false,

    setTab(tab) {
      this.activeTab = tab;
    },

    async saveSettings() {
      if (this.isSaving) return;
      this.isSaving = true;

      try {
        const response = await jQuery.ajax({
          url: beeCartAdminData.ajax_url,
          type: "POST",
          data: {
            action: "beecart_save_settings",
            security: beeCartAdminData.nonce,
            settings: JSON.stringify(this.settings),
          },
        });

        if (response.success) {
          alert(response.data);
          window.location.reload();
        } else {
          alert("Error: " + response.data);
        }
      } catch (error) {
        alert("An error occurred while saving.");
      } finally {
        this.isSaving = false;
      }
    },
  });

  Alpine.data("colorPicker", (settingKey) => ({
    get color() {
      return Alpine.store("admin").settings[settingKey];
    },
    set color(val) {
      Alpine.store("admin").settings[settingKey] = val;
    },
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
});

jQuery(document).on("click", "#bee-save-settings", function (e) {
  Alpine.store("admin").saveSettings();
});
