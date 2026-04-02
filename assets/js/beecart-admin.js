document.addEventListener("alpine:init", () => {
  Alpine.store("admin", {
    activeTab: "placement",
    preview: window.innerWidth >= 991,
    settings: {
      enable_cart_drawer: false,
      auto_open_cart: true,
      menu_placement: "bottom",
      progress_bars: [
        {
          type: "subtotal",
          away_text: "You're only {amount} away from {goal}",
          completed_text: "🎉 Congratulations! You have unlocked all rewards.",
          show_labels: true,
          checkpoints: [
            { threshold: 50, label: "Free Shipping", icon: "truck" },
            { threshold: 100, label: "10% Discount", icon: "tag" },
          ],
        },
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
      rewards_bars_layout: "column",
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
      cart_bubble_bg: "#000000",
      cart_bubble_text: "#ffffff",
      show_cart_count: true,
      cart_title: "Your Cart",
      show_announcement: false,
      announcement_text: "Your products are reserved for {timer}!",
      announcement_bg: "#fffbeb",
      announcement_text_color: "#92400e",
      announcement_font_size: "13px",
      announcement_bar_size: "medium",
      timer_duration: "15",
      show_item_images: true,
      show_savings: true,
      trans_savings_prefix: "Save",
      show_upsells: true,
      show_upsells_on_empty: true,
      upsell_title: "You might also like...",
      upsell_max: 3,
      upsell_source: "best_sellers",
      upsell_category: "",
      upsell_btn_text: "Add to Cart",
      show_trust_badges: true,
      trust_badge_image: "",
      custom_css: "",
      trans_checkout_btn: "Checkout",
      trans_continue_shopping: "Continue Shopping",
      trans_empty_cart: "Your cart is currently empty.",
      trans_subtotal: "Subtotal",
      trans_coupon_placeholder: "Coupon code",
      trans_coupon_apply_btn: "Apply",
      trans_discounts: "Discounts",
      trans_coupon_accordion_title: "Have a Coupon?",
      show_shipping_notice: true,
      shipping_notice_text: "Shipping and taxes will be calculated at checkout.",
      show_subtotal_on_checkout: true,
      enable_total_line: true,
      trans_total: "Total",
      ...(Array.isArray(beecartAdminData.settings)
        ? {}
        : beecartAdminData.settings),
    },
    addProgressBar() {
      this.settings.progress_bars.push({
        type: "subtotal",
        away_text: "You're only {amount} away from {goal}",
        completed_text: "🎉 Congratulations! You have unlocked all rewards.",
        show_labels: true,
        checkpoints: [
          { threshold: 50, label: "Free Shipping", icon: "truck" },
        ],
      });
    },
    removeProgressBar(index) {
      if (this.settings.progress_bars.length > 1) {
        this.settings.progress_bars.splice(index, 1);
      }
    },
    isSaving: false,
    isDirty: false,
    $intercept: false,
    savedSettingsSnapshot: '',

    init() {
      // Create initial snapshot for comparison
      this.savedSettingsSnapshot = JSON.stringify(this.settings);

      // We use effect to track changes and update isDirty reactively
      Alpine.effect(() => {
        if (this.$intercept) return;
        // Deep compare by stringifying the reactive object
        const current = JSON.stringify(this.settings);
        this.isDirty = current !== this.savedSettingsSnapshot;
      });

      window.addEventListener("resize", () => {
        this.preview = window.innerWidth >= 991;
      });
    },

    discardSettings() {
      if (!this.isDirty) return;
      
      this.$intercept = true;
      const original = JSON.parse(this.savedSettingsSnapshot);
      
      // Update all keys to restore state while maintaining proxy references
      Object.keys(original).forEach(key => {
        this.settings[key] = original[key];
      });
      
      this.isDirty = false;
      setTimeout(() => { this.$intercept = false; }, 0);
    },

    setTab(tab) {
      this.activeTab = tab;
    },

    async saveSettings() {
      if (this.isSaving) return;
      this.isSaving = true;

      try {
        const response = await jQuery.ajax({
          url: beecartAdminData.ajax_url,
          type: "POST",
          data: {
            action: "beecart_save_settings",
            security: beecartAdminData.nonce,
            settings: JSON.stringify(this.settings),
          },
        });

        if (response.success) {
          // Update the snapshot for future comparison
          this.savedSettingsSnapshot = JSON.stringify(this.settings);
          this.isDirty = false;
          this.showToast(response.data || "Settings saved!", "success");
        } else {
          this.showToast((response.data || "An error occurred."), "error");
        }
      } catch (error) {
        this.showToast("Network error. Please try again.", "error");
      } finally {
        this.isSaving = false;
      }
    },

    showToast(message, type = "success") {
      // Remove any existing toast
      const existing = document.getElementById("bc-admin-toast");
      if (existing) existing.remove();

      const isSuccess = type === "success";
      const toast = document.createElement("div");
      toast.id = "bc-admin-toast";
      toast.style.cssText = [
        "position:fixed",
        "bottom:24px",
        "right:24px",
        "z-index:99999",
        "display:flex",
        "align-items:center",
        "gap:10px",
        "padding:12px 18px",
        "border-radius:10px",
        "font-size:14px",
        "font-weight:500",
        "line-height:1.4",
        "box-shadow:0 4px 20px rgba(0,0,0,0.15)",
        "cursor:pointer",
        "transition:opacity 0.3s ease, transform 0.3s ease",
        "opacity:0",
        "transform:translateY(8px)",
        isSuccess
          ? "background:#f0fdf4;color:#166534;border:1px solid #bbf7d0"
          : "background:#fef2f2;color:#991b1b;border:1px solid #fecaca",
      ].join(";");

      const icon = isSuccess ? "✓" : "✕";
      toast.innerHTML = `<strong style="font-size:16px">${icon}</strong> ${message} <span style="margin-left:8px;opacity:0.5;font-size:16px">&times;</span>`;

      document.body.appendChild(toast);

      // Animate in
      requestAnimationFrame(() => {
        toast.style.opacity = "1";
        toast.style.transform = "translateY(0)";
      });

      const dismiss = () => {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(8px)";
        setTimeout(() => toast.remove(), 300);
      };

      toast.addEventListener("click", dismiss);
      setTimeout(dismiss, 4000);
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
