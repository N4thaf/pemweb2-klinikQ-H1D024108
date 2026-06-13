<div>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-ios-label">Buat Akun Baru</h2>
        <p class="text-sm text-ios-label-secondary mt-1">Daftar sebagai petugas klinik.</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <div>
            <label for="name" class="label-ios">Nama Lengkap</label>
            <input
                id="name"
                type="text"
                wire:model="name"
                class="input-ios @error('name') input-error @enderror"
                placeholder="Nama lengkap"
                autofocus
            />
            @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="reg-email" class="label-ios">Email</label>
            <input
                id="reg-email"
                type="email"
                wire:model="email"
                class="input-ios @error('email') input-error @enderror"
                placeholder="nama@email.com"
            />
            @error('email')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="reg-password" class="label-ios">Password</label>
            <input
                id="reg-password"
                type="password"
                wire:model="password"
                class="input-ios @error('password') input-error @enderror"
                placeholder="Minimal 8 karakter"
            />
            @error('password')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password-confirm" class="label-ios">Konfirmasi Password</label>
            <input
                id="password-confirm"
                type="password"
                wire:model="password_confirmation"
                class="input-ios"
                placeholder="Ulangi password"
            />
        </div>

        <button type="submit" id="btn-register" class="btn-primary w-full" wire:loading.attr="disabled">
            <span wire:loading.remove>Daftar</span>
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
            Sudah punya akun?
            <a href="{{ route('login') }}" wire:navigate class="text-ios-blue font-medium hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
