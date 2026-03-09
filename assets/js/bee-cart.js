document.addEventListener("alpine:init", () => {
  Alpine.data("beeCart", (initialMinutes = 15) => ({
    isOpen: false,
    isLoading: false,
    cartHtml: "",
    cartCount: 0,
    timerCount: initialMinutes * 60,
    timerInterval: null,

    init() {
      // Bind WooCommerce added to cart event
      if (typeof jQuery !== "undefined") {
        jQuery(document.body).on("added_to_cart", () => {
          this.openCart();
        });

        // AJAX Add to Cart for Single Product Forms
        jQuery(document).on("submit", "form.cart", (e) => {
          const $form = jQuery(e.target);
          if ($form.closest(".product-type-external").length) return;

          e.preventDefault();
          this.isLoading = true;
          this.isOpen = true; // Open immediately to show loading spinner
          document.body.style.overflow = "hidden";

          const formData = new FormData(e.target);
          formData.append("action", "beecart_add_to_cart");
          formData.append("security", beeCartData.nonce);

          fetch(beeCartData.ajax_url, {
            method: "POST",
            body: formData,
          })
            .then((res) => res.json())
            .then((res) => {
              if (res.success) {
                this.cartHtml = res.data.html;
                this.cartCount = res.data.count;
                this.updateHeaderBubble();
                jQuery(document.body).trigger("wc_fragment_refresh");
                if (!this.timerInterval) this.startTimer();
              } else {
                // Fallback to strict JS submission
                $form.unbind("submit").submit();
              }
            })
            .catch(() => {
              $form.unbind("submit").submit();
            })
            .finally(() => {
              this.isLoading = false;
            });
        });
      }
    },

    openCart() {
      this.isOpen = true;
      document.body.style.overflow = "hidden";
      this.getCart();
      if (!this.timerInterval) this.startTimer();
    },

    closeCart() {
      this.isOpen = false;
      document.body.style.overflow = "";
    },

    async getCart() {
      this.isLoading = true;
      try {
        const formData = new FormData();
        formData.append("action", "beecart_get_cart");
        formData.append("security", beeCartData.nonce);

        const response = await fetch(beeCartData.ajax_url, {
          method: "POST",
          body: formData,
        });
        const res = await response.json();
        if (res.success) {
          this.cartHtml = res.data.html;
          this.cartCount = res.data.count;
          this.updateHeaderBubble();
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    },

    async updateItem(key, qty) {
      if (qty < 0) return;
      this.isLoading = true;
      try {
        const formData = new FormData();
        formData.append("action", "beecart_update_item");
        formData.append("security", beeCartData.nonce);
        formData.append("cart_item_key", key);
        formData.append("quantity", qty);

        const response = await fetch(beeCartData.ajax_url, {
          method: "POST",
          body: formData,
        });
        const res = await response.json();
        if (res.success) {
          this.cartHtml = res.data.html;
          this.cartCount = res.data.count;
          this.updateHeaderBubble();
          // Update standard WooCommerce fragments globally outside cart
          if (typeof jQuery !== "undefined") {
            jQuery(document.body).trigger("wc_fragment_refresh");
          }
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    },

    async addUpsell(id) {
      this.isLoading = true;
      try {
        const formData = new FormData();
        formData.append("action", "beecart_add_to_cart");
        formData.append("security", beeCartData.nonce);
        formData.append("product_id", id);
        formData.append("quantity", 1);

        const response = await fetch(beeCartData.ajax_url, {
          method: "POST",
          body: formData,
        });
        const res = await response.json();
        if (res.success) {
          this.cartHtml = res.data.html;
          this.cartCount = res.data.count;
          this.updateHeaderBubble();
          if (typeof jQuery !== "undefined") {
            jQuery(document.body).trigger("wc_fragment_refresh");
          }
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    },

    async applyCoupon(code) {
      if (!code) return;
      this.isLoading = true;
      try {
        const formData = new FormData();
        formData.append("action", "beecart_apply_coupon");
        formData.append("security", beeCartData.nonce);
        formData.append("coupon", code);

        const response = await fetch(beeCartData.ajax_url, {
          method: "POST",
          body: formData,
        });
        const res = await response.json();
        if (res.success) {
          this.cartHtml = res.data.html;
          this.cartCount = res.data.count;
          this.updateHeaderBubble();
          if (typeof jQuery !== "undefined") {
            jQuery(document.body).trigger("wc_fragment_refresh");
          }
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    },

    updateHeaderBubble() {
      document.querySelectorAll(".bee-cart-count-bubble").forEach((b) => {
        b.textContent = this.cartCount;
      });
    },

    startTimer() {
      this.timerInterval = setInterval(() => {
        if (this.timerCount > 0) {
          this.timerCount--;
        } else {
          clearInterval(this.timerInterval);
        }
      }, 1000);
    },

    formatTime(seconds) {
      const m = Math.floor(seconds / 60);
      const s = seconds % 60;
      return (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
    },
  }));
});
