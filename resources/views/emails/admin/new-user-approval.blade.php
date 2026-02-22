<x-mail::message>
    # Pemberitahuan Persetujuan User Baru

    Seorang pengguna baru telah mendaftar dan sedang menunggu persetujuan Anda.

    **Detail Pengguna:**
    - **Nama:** {{ $user->name }}
    - **Email:** {{ $user->email }}

    Silakan tinjau dan berikan persetujuan melalui halaman "User Approvals" di dashboard admin Anda.

    @component('mail::button', ['url' => route('admin.approvals.index')])
        Buka Halaman Approval
    @endcomponent

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
