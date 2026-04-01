<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'rewards'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold flex items-center gap-2 m-0"><span class="dashicons dashicons-awards"></span> Progress Rewards</h2>
    <p class="text-sm text-gray-500 mt-1">Configure tiered rewards that customers unlock as they add items to their cart.</p>

    <div class="space-y-8">
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Configuration</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="enable_rewards_bar" x-model="$store.admin.settings.enable_rewards_bar" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <label for="enable_rewards_bar" class="text-sm font-medium leading-none">Enable Tiered Rewards Bar</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_rewards_on_empty" x-model="$store.admin.settings.show_rewards_on_empty" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <label for="show_rewards_on_empty" class="text-sm font-medium leading-none">Show rewards when cart is empty</label>
                </div>
            </div>
        </div>
        <!-- Appearance -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Design Appearance</h3>
            <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                <!-- Background color -->
                <div class="space-y-2" x-data="colorPicker('rewards_bar_bg')">
                    <label for="rewards_bar_bg" class="text-sm font-medium">Background Color</label>
                    <div class="flex items-center gap-2">
                        <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                            <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                        </label>
                        <input type="text" id="rewards_bar_bg" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                    </div>
                </div>
                <!-- Cart accent color -->
                <div class="space-y-2" x-data="colorPicker('rewards_bar_fg')">
                    <label for="rewards_bar_fg" class="text-sm font-medium">Progress Color (Fill)</label>
                    <div class="flex items-center gap-2">
                        <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                            <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                        </label>
                        <input type="text" id="rewards_bar_fg" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                    </div>
                </div>

            </div>
        </div>

        <button @click="$store.admin.addProgressBar()" type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-100 h-9 px-4 transition-colors cursor-pointer">
            <span class="dashicons dashicons-plus mr-2 text-sm"></span> Add New Progress Bar
        </button>

        <!-- Progress Bars Configuration -->
        <div class="space-y-4 pt-6 border-t border-solid border-gray-100">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400">Configuration</h3>
            <div class="space-y-8">
                <template x-for="(bar, barIndex) in $store.admin.settings.progress_bars" :key="barIndex">
                    <div class="space-y-6 relative pb-8 border-b border-solid border-gray-100 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-blue-500">Progress Bar #<span x-text="barIndex + 1"></span></h4>
                            <button @click="$store.admin.removeProgressBar(barIndex)" x-show="$store.admin.settings.progress_bars.length > 1" type="button" class="text-red-500 hover:text-red-600 text-xs font-medium flex items-center gap-1 cursor-pointer">
                                <span class="dashicons dashicons-trash text-sm"></span> Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-4">
                            <!-- Left: Messages & Basis -->
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Threshold Basis</label>
                                    <select x-model="bar.type" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                                        <option value="subtotal">Cart Subtotal ($)</option>
                                        <option value="quantity">Total Item Quantity</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Goal Message</label>
                                    <input type="text" x-model="bar.away_text" placeholder="You're only {amount} away from {goal}" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                                    <p class="text-[11px] text-gray-400">Use <strong>{amount}</strong> for remaining value and <strong>{goal}</strong> for current tier label.</p>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Completion Message</label>
                                    <textarea x-model="bar.completed_text" rows="2" class="flex w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring"></textarea>
                                </div>
                            </div>

                            <!-- Right: Checkpoints -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-medium">Reward Levels</label>
                                    <button @click="bar.checkpoints.push({ threshold: 0, label: 'Reward Name', icon: 'truck' })" type="button" class="text-xs text-blue-600 hover:text-blue-800 font-bold uppercase transition-colors pointer-cursor">+ Add Level</button>
                                </div>

                                <div class="space-y-3">
                                    <template x-for="(cp, cpIndex) in bar.checkpoints" :key="cpIndex">
                                        <div class="flex items-start gap-2 p-3 rounded-md border border-solid border-gray-200 bg-gray-50/50 relative group">
                                            <div class="grid grid-cols-2 gap-2 flex-grow">
                                                <div class="space-y-1">
                                                    <label class="text-[10px] font-bold uppercase text-gray-400">Threshold Value</label>
                                                    <input type="number" x-model.number="cp.threshold" class="flex h-8 w-full rounded-md border border-gray-300 bg-white px-2 py-1 text-xs focus:ring-1 focus:ring-ring">
                                                </div>
                                                <div class="space-y-1">
                                                    <label class="text-[10px] font-bold uppercase text-gray-400">Icon</label>
                                                    <select x-model="cp.icon" class="flex h-8 w-full rounded-md border border-gray-300 bg-white px-2 py-1 text-xs focus:ring-1 focus:ring-ring">
                                                        <template x-for="(label, val) in beecartAdminData.icons" :key="val">
                                                            <option :value="val" x-text="label"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div class="col-span-2 space-y-1">
                                                    <label class="text-[10px] font-bold uppercase text-gray-400">Reward Description (Label)</label>
                                                    <input type="text" x-model="cp.label" class="flex h-8 w-full rounded-md border border-gray-300 bg-white px-2 py-1 text-xs focus:ring-1 focus:ring-ring">
                                                </div>
                                            </div>
                                            <button @click="bar.checkpoints.splice(cpIndex, 1)" type="button" class="mt-4 text-gray-400 hover:text-red-500 transition-colors cursor-pointer">
                                                <span class="dashicons dashicons-no-alt text-xs"></span>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>