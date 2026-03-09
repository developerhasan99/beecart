jQuery(document).ready(function ($) {
  const $preview = $(".bee_z-10"); // the preview container
  const $goalsList = $("#bee-goals-list");

  // Tab switching logic
  const tabBtns = document.querySelectorAll(".bee_tab-btn");
  const tabPanes = document.querySelectorAll(".bee_tab-pane");

  tabBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      tabBtns.forEach((b) => {
        b.classList.remove("bee_bg-secondary", "bee_text-secondary-foreground");
        b.classList.add("bee_text-muted-foreground");
      });
      btn.classList.add("bee_bg-secondary", "bee_text-secondary-foreground");
      btn.classList.remove("bee_text-muted-foreground");

      tabPanes.forEach((p) => {
        p.classList.add("bee_hidden");
        p.classList.remove("bee_block");
      });
      const target = btn.getAttribute("data-target");
      document.getElementById(target).classList.remove("bee_hidden");
      document.getElementById(target).classList.add("bee_block");
    });
  });

  function updatePreviewColors(color) {
    document.querySelectorAll('[style*="background-color"]').forEach((el) => {
      if (el.closest(".bee_relative.bee_z-10")) {
        if (el.classList.contains("bee_bg-primary")) {
          el.style.backgroundColor = color;
        }
      }
    });
    document.querySelectorAll('[style*="color:"]').forEach((el) => {
      if (el.classList.contains("bee_text-primary")) {
        el.style.color = color;
      }
    });
  }

  // Color picker sync
  $('input[type="color"]').on("input", function (e) {
    const hexInput = $(this).parent().next("input");
    hexInput.val(e.target.value);
    updatePreviewColors(e.target.value);
  });

  // Watch for checkbox changes
  $("#enable_coupon").on("change", function (e) {
    $("#preview-coupon-section").css(
      "display",
      e.target.checked ? "flex" : "none",
    );
  });

  $("#enable_badges").on("change", function (e) {
    $("#preview-badges-section").css(
      "display",
      e.target.checked ? "flex" : "none",
    );
  });

  // Add Goal Handler
  $("#bee-add-goal").on("click", function () {
    const $firstItem = $(".bee-goal-item").first();
    if ($firstItem.length) {
      const $item = $firstItem.clone();
      $item.find("input").val("");
      $item.find(".bee-icon-select").val("star");
      $goalsList.append($item);
    } else {
      // Create fresh if empty
      const html = `
      <div class="bee-goal-item bee_rounded-lg bee_border bee_border-border bee_bg-card bee_p-4 bee_shadow-sm bee_relative bee_group">
          <button class="bee-remove-goal bee_absolute bee_-top-2 bee_-right-2 bee_rounded-full bee_bg-destructive bee_text-destructive-foreground bee_w-6 bee_h-6 bee_flex bee_items-center bee_justify-center bee_opacity-0 group-hover:bee_opacity-100 bee_transition-opacity bee_shadow-sm">
              <span class="dashicons dashicons-no-alt bee_text-sm"></span>
          </button>
          <div class="bee_grid bee_gap-3">
              <div class="bee_grid bee_grid-cols-2 bee_gap-3">
                  <div class="bee_space-y-1.5">
                      <label class="bee_text-xs bee_text-muted-foreground">Threshold</label>
                      <input type="number" value="" class="bee-goal-threshold bee_flex bee_h-9 bee_w-full bee_rounded-md bee_border bee_border-input bee_bg-transparent bee_px-3 bee_py-1 bee_text-sm bee_shadow-sm bee_transition-colors focus-visible:bee_outline-none focus-visible:bee_ring-1 focus-visible:bee_ring-ring">
                  </div>
                  <div class="bee_space-y-1.5">
                      <label class="bee_text-xs bee_text-muted-foreground">Icon</label>
                      <select class="bee-icon-select bee_flex bee_h-9 bee_w-full bee_items-center bee_justify-between bee_rounded-md bee_border bee_border-input bee_bg-transparent bee_px-3 bee_py-1 bee_text-sm bee_shadow-sm bee_ring-offset-background focus:bee_outline-none focus:bee_ring-1 focus:bee_ring-ring">
                          <option value="truck">Truck</option>
                          <option value="tag">Tag</option>
                          <option value="gift">Gift</option>
                          <option value="star" selected>Star</option>
                          <option value="credit-card">Card</option>
                          <option value="check">Check</option>
                          <option value="shopping-bag">Bag</option>
                      </select>
                  </div>
              </div>
              <div class="bee_space-y-1.5">
                  <label class="bee_text-xs bee_text-muted-foreground">Reward Label</label>
                  <input type="text" value="" class="bee-goal-label bee_flex bee_h-9 bee_w-full bee_rounded-md bee_border bee_border-input bee_bg-transparent bee_px-3 bee_py-1 bee_text-sm bee_shadow-sm bee_transition-colors focus-visible:bee_outline-none focus-visible:bee_ring-1 focus-visible:bee_ring-ring">
              </div>
          </div>
      </div>`;
      $goalsList.append(html);
    }
  });

  // Remove Goal Handler
  $(document).on("click", ".bee-remove-goal", function () {
    $(this).closest(".bee-goal-item").remove();
  });

  // Save Settings Handler
  $("#bee-save-settings").on("click", function () {
    const $btn = $(this);
    const goals = [];

    $(".bee-goal-item").each(function () {
      const threshold = $(this).find(".bee-goal-threshold").val();
      const label = $(this).find(".bee-goal-label").val();
      const icon = $(this).find(".bee-icon-select").val();

      if (threshold) {
        goals.push({ threshold, label, icon });
      }
    });

    const settings = {
      progress_type: $('select[name="progress_type"]').val(),
      goals: goals,
      primary_color: $('input[name="primary_color"]').val(),
      enable_coupon: $("#enable_coupon").prop("checked"),
      enable_badges: $("#enable_badges").prop("checked"),
    };

    const originalText = $btn.text();
    $btn.prop("disabled", true).text("Saving...");

    $.ajax({
      url: beeCartAdminData.ajax_url,
      type: "POST",
      data: {
        action: "beecart_save_settings",
        security: beeCartAdminData.nonce,
        settings: JSON.stringify(settings),
      },
      success: function (response) {
        if (response.success) {
          $btn.text("Saved!");
          setTimeout(() => {
            $btn.prop("disabled", false).text(originalText);
          }, 2000);
        }
      },
      error: function () {
        $btn.text("Error");
        setTimeout(() => {
          $btn.prop("disabled", false).text(originalText);
        }, 2000);
      },
    });
  });
});
