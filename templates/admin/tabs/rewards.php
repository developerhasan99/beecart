<div x-show="$store.admin.activeTab === 'rewards'"
    class="tab-pane p-6"
    style="display: none;"
    x-data="{ 
        goals: <?php echo esc_js(json_encode($settings['goals'] ?? [])); ?>,
        addGoal() {
            this.goals.push({ threshold: 0, label: 'New Reward', icon: 'truck' });
        },
        removeGoal(index) {
            this.goals.splice(index, 1);
        }
     }">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-awards"></span> Progress Rewards</h2>
    <div class="space-y-6">
        <div class="space-y-2">
            <label class="text-sm font-medium">Threshold Basis</label>
            <select name="progress_type" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                <option value="subtotal" <?php selected($settings['progress_type'] ?? 'subtotal', 'subtotal'); ?>>Cart Subtotal ($)</option>
                <option value="quantity" <?php selected($settings['progress_type'] ?? 'subtotal', 'quantity'); ?>>Total Item Quantity</option>
            </select>
        </div>

        <div class="space-y-4">
            <label class="text-sm font-medium">Reward Checkpoints</label>

            <div class="space-y-3">
                <template x-for="(goal, index) in goals" :key="index">
                    <div class="bee-goal-item rounded-lg border border-gray-200 bg-white p-4 shadow-sm relative group">
                        <!-- Hidden inputs for form submission if needed, or we handle via Alpine -->
                        <input type="hidden" :name="'goals['+index+'][threshold]'" :value="goal.threshold">
                        <input type="hidden" :name="'goals['+index+'][label]'" :value="goal.label">
                        <input type="hidden" :name="'goals['+index+'][icon]'" :value="goal.icon">

                        <button @click="removeGoal(index)" type="button" class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm cursor-pointer">
                            <span class="dashicons dashicons-no-alt text-sm"></span>
                        </button>

                        <div class="grid gap-3">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="text-xs text-gray-500 font-bold uppercase tracking-wider">Threshold</label>
                                    <input type="number" x-model.number="goal.threshold" class="flex h-9 w-full rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus:outline-none focus:ring-1 focus:ring-ring">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs text-gray-500 font-bold uppercase tracking-wider">Icon</label>
                                    <select x-model="goal.icon" class="flex h-9 w-full items-center justify-between rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-ring">
                                        <?php foreach ($icons as $val => $name): ?>
                                            <option value="<?php echo esc_attr($val); ?>"><?php echo esc_html($name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs text-gray-500 font-bold uppercase tracking-wider">Reward Label</label>
                                <input type="text" x-model="goal.label" class="flex h-9 w-full rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus:outline-none focus:ring-1 focus:ring-ring">
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <button @click="addGoal" type="button" class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-100 h-10 px-4 transition-colors cursor-pointer">
                <span class="dashicons dashicons-plus mr-2 text-sm"></span> Add Goal Checkpoint
            </button>
        </div>
    </div>
</div>