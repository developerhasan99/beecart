document.addEventListener("alpine:init", () => {
  Alpine.store("admin", {
    activeTab: "placement",
    settings: {
      enable_cart_drawer: true,
      cart_position: "right",
      auto_open_cart: true,
      menu_placement: "bottom",
      progress_type: "subtotal",
      goals: [
        { threshold: 50, label: "Free Shipping", icon: "truck" },
        { threshold: 100, label: "20% Discount", icon: "tag" },
      ],
      primary_color: "#000000",
      enable_coupon: true,
      enable_badges: true,
      enable_rewards_bar: true,
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
      btn_radius: "5px",
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
      announcement_bar_size: "medium",
      enable_timer: false,
      timer_duration: "0",
      show_item_images: true,
      show_savings: true,
      trans_savings_prefix: "Save",
      qty_selector_type: "boxed",
      show_upsells: true,
      show_upsells_on_empty: true,
      upsell_title: "You might also like...",
      upsell_max: 3,
      upsell_source: "random",
      upsell_layout: "list",
      upsell_btn_text: "Add to Cart",
      show_trust_badges: true,
      trust_badge_image:
        "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 40' width='300' height='40'%3E%3Crect width='300' height='40' fill='transparent' rx='4'/%3E%3Ctext x='150' y='25' font-family='sans-serif' font-size='14' font-weight='bold' fill='%239ca3af' text-anchor='middle'%3ESECURE CHECKOUT%3C/text%3E%3C/svg%3E",
      custom_css: "",
      trans_checkout_btn: "Checkout",
      trans_view_cart_btn: "View Cart",
      trans_continue_shopping: "Continue Shopping",
      trans_empty_cart: "Your cart is currently empty.",
      trans_subtotal: "Subtotal",
      trans_savings: "You save",
      trans_coupon_placeholder: "Coupon code",
      trans_coupon_apply_btn: "Apply",
      trans_rewards_away: "You're only {amount} away from {goal}",
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
