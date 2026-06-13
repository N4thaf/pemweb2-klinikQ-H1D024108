<div>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-ios-label">Masuk ke Akun</h2>
        <p class="text-sm text-ios-label-secondary mt-1">Gunakan akun yang telah terdaftar.</p>
    </div>

    <form wire:submit="login" class="space-y-4">
        <div>
            <label for="email" class="label-ios">Email</label>
            <input
                id="email"
                type="email"
                wire:model="email"
                class="input-ios @error('email') input-error @enderror"
                placeholder="nama@email.com"
                autocomplete="email"
                autofocus
            />
            @error('email')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="label-ios">Password</label>
            <input
                id="password"
                type="password"
                wire:model="password"
                class="input-ios @error('password') input-error @enderror"
                placeholder="Masukkan password"
                autocomplete="current-password"
            />
            @error('password')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" wire:model="remember" class="rounded border-ios-separator text-ios-blue focus:ring-ios-blue" />
                <span class="text-sm text-ios-label-secondary">Ingat saya</span>
            </label>
        </div>

        <button type="submit" id="btn-login" class="btn-primary w-full" wire:loading.attr="disabled">
            <span wire:loading.remove>Masuk</span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            </span>
        </button>
    </form>

    <div class="mt-5 pt-5 border-t border-ios-separator text-center">
        <p class="text-sm text-ios-label-secondary">
            Belum punya akun?
            <a href="{{ route('register') }}" wire:navigate class="text-ios-blue font-medium hover:underline">Daftar sekarang</a>
        </p>
    </div>

    <div class="mt-4 p-3 bg-ios-bg rounded-ios text-xs text-ios-label-secondary">
        <p class="font-medium text-ios-label mb-1">Akun demo:</p>
        <p>Admin: admin@klinikq.test / password</p>
        <p>Petugas: petugas@klinikq.test / password</p>
    </div>
</div>
