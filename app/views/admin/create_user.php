
    <form id="add-user-form" class="space-y-10 mt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <div>
                <label for="name" class="block font-semibold text-brand-800 mb-2">Name:</label>
                <input type="text" name="name" id="name"  placeholder="Enter your first name"
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="lastname" class="block font-semibold text-brand-800 mb-2">Last Name:</label>
                <input type="text" name="lastName" id="lastName" placeholder="Enter your last name"
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="email" class="block font-semibold text-brand-800 mb-2">Email:</label>
                <input type="email" name="email" id="email" placeholder="name@example.com"
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="phone" class="block font-semibold text-brand-800 mb-2">Phone:</label>
                <input type="tel" name="phone" id="phone" pattern="^\+\d{6,15}$" placeholder="+34123456789" maxlength="16"
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="password" class="block font-semibold text-brand-800 mb-2">Password:</label>
                <input type="password" name="password" id="password" placeholder="At least 8 characters, 1 uppercase, 1 number, 1 special char"
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="role" class="block font-semibold text-brand-800 mb-2">Role:</label>
                <select name="role" id="role"
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <div>
            <button type="submit" id="submit-button"
                class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
                Create User
            </button>
        </div>
        <div id="form-message" class="mt-4 text-center text-sm font-semibold font-normal"></div>
    </form>
