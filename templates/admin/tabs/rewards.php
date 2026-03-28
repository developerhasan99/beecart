<div x-show="$store.admin.activeTab === 'rewards'"
    class="tab-pane p-6"
    style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-awards"></span> Progress Rewards</h2>
    <div class="space-y-8">
        <!-- General Configuration -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">General Settings</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="enable_rewards_bar" x-model="$store.admin.settings.enable_rewards_bar" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <label for="enable_rewards_bar" class="text-sm font-medium leading-none">Enable Tiered Rewards Bar</label>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_rewards_on_empty" x-model="$store.admin.settings.show_rewards_on_empty" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" x-bind:disabled="!$store.admin.settings.enable_rewards_bar">
                    <label for="show_rewards_on_empty" class="text-sm font-medium leading-none whitespace-nowrap peer-disabled:opacity-50 peer-disabled:cursor-not-allowed">Show rewards on empty cart</label>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium">Progress Bar Colors</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2" x-data="colorPicker('rewards_bar_bg')">
                            <label for="rewards_bar_bg" class="text-xs text-gray-500">Background Color</label>
                            <div class="flex items-center gap-2">
                                <label class="relative cursor-pointer w-8 h-8 rounded-md border border-gray-200 shadow-sm overflow-hidden shrink-0">
                                    <input type="color" :value="isValid ? color : '#E2E2E2'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                                </label>
                                <input type="text" id="rewards_bar_bg" :value="color" @input="updateInput" class="flex h-9 w-full rounded-md border border-gray-300 bg-white px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                            </div>
                        </div>
                        <div class="space-y-2" x-data="colorPicker('rewards_bar_fg')">
                            <label for="rewards_bar_fg" class="text-xs text-gray-500">Foreground Color</label>
                            <div class="flex items-center gap-2">
                                <label class="relative cursor-pointer w-8 h-8 rounded-md border border-gray-200 shadow-sm overflow-hidden shrink-0">
                                    <input type="color" :value="isValid ? color : '#93D3FF'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                                </label>
                                <input type="text" id="rewards_bar_fg" :value="color" @input="updateInput" class="flex h-9 w-full rounded-md border border-gray-300 bg-white px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium">Checkpoint Icon Colors</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2" x-data="colorPicker('rewards_complete_icon_color')">
                            <label for="rewards_complete_icon_color" class="text-xs text-gray-500">Complete Tier Color</label>
                            <div class="flex items-center gap-2">
                                <label class="relative cursor-pointer w-8 h-8 rounded-md border border-gray-200 shadow-sm overflow-hidden shrink-0">
                                    <input type="color" :value="isValid ? color : '#4D4949'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                                </label>
                                <input type="text" id="rewards_complete_icon_color" :value="color" @input="updateInput" class="flex h-9 w-full rounded-md border border-gray-300 bg-white px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                            </div>
                        </div>
                        <div class="space-y-2" x-data="colorPicker('rewards_incomplete_icon_color')">
                            <label for="rewards_incomplete_icon_color" class="text-xs text-gray-500">Incomplete Tier Color</label>
                            <div class="flex items-center gap-2">
                                <label class="relative cursor-pointer w-8 h-8 rounded-md border border-gray-200 shadow-sm overflow-hidden shrink-0">
                                    <input type="color" :value="isValid ? color : '#4D4949'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                                </label>
                                <input type="text" id="rewards_incomplete_icon_color" :value="color" @input="updateInput" class="flex h-9 w-full rounded-md border border-gray-300 bg-white px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="trans_rewards_away" class="text-sm font-medium">Threshold Message (In-progress)</label>
                    <input type="text" id="trans_rewards_away" x-model="$store.admin.settings.trans_rewards_away" placeholder="You're only {amount} away from {goal}" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors">
                    <p class="text-[11px] text-gray-400 mt-1">Use <strong>{amount}</strong> for remaining value and <strong>{goal}</strong> for reward label.</p>
                </div>

                <div class="space-y-2">
                    <label for="rewards_completed_text" class="text-sm font-medium">Completion Message</label>
                    <textarea id="rewards_completed_text" x-model="$store.admin.settings.rewards_completed_text" rows="2" placeholder="Text after completing full rewards bar..." class="flex w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors"></textarea>
                </div>
            </div>
        </div>


        <div class="space-y-2 pt-6 border-0 border-t border-solid border-gray-200">
            <label for="progress_type" class="text-sm font-medium">Threshold Basis</label>
            <select id="progress_type" x-model="$store.admin.settings.progress_type" class="flex h-10 w-full items-center justify-between rounded-md border border-solid border-gray-300 bg-white px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                <option value="subtotal">Cart Subtotal ($)</option>
                <option value="quantity">Total Item Quantity</option>
            </select>
        </div>

        <div class="space-y-4">
            <label class="text-sm font-medium">Reward Checkpoints</label>

            <div class="space-y-3">
                <template x-for="(goal, index) in $store.admin.settings.goals" :key="index">
                    <div class="bee-goal-item rounded-lg border border-solid border-gray-200 bg-white p-4 shadow-sm relative group">
                        <button @click="$store.admin.settings.goals.splice(index, 1)" type="button" class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm cursor-pointer">
                            <span class="dashicons dashicons-no-alt text-sm"></span>
                        </button>

                        <div class="grid gap-3">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label :for="'goal_threshold_' + index" class="text-xs text-gray-500 font-bold uppercase tracking-wider">Threshold</label>
                                    <input :id="'goal_threshold_' + index" type="number" x-model.number="goal.threshold" class="flex h-9 w-full rounded-md border border-solid border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus:outline-none focus:ring-1 focus:ring-ring">
                                </div>
                                <div class="space-y-1.5">
                                    <label :for="'goal_icon_' + index" class="text-xs text-gray-500 font-bold uppercase tracking-wider">Icon</label>
                                    <select :id="'goal_icon_' + index" x-model="goal.icon" class="flex h-9 w-full items-center justify-between rounded-md border border-solid border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-ring">
                                        <template x-for="(label, val) in beecartAdminData.icons" :key="val">
                                            <option :value="val" x-text="label"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label :for="'goal_label_' + index" class="text-xs text-gray-500 font-bold uppercase tracking-wider">Reward Label</label>
                                <input :id="'goal_label_' + index" type="text" x-model="goal.label" class="flex h-9 w-full rounded-md border border-solid border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus:outline-none focus:ring-1 focus:ring-ring">
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <button @click="$store.admin.settings.goals.push({ threshold: 0, label: 'New Reward', icon: 'truck' })" type="button" class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-solid border-gray-300 bg-white hover:bg-gray-100 h-10 px-4 transition-colors cursor-pointer">
                <span class="dashicons dashicons-plus mr-2 text-sm"></span> Add Goal Checkpoint
            </button>
        </div>
    </div>
</div>