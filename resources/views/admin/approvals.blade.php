<x-admin-layout>
    <x-slot name="header">
        <h2
            class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
        >
            {{ __('User Approvals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('status'))
            <div
                class="mb-4 text-sm font-medium text-green-600 dark:text-green-400"
            >
                {{ session('status') }}
            </div>
            @endif

            <div
                class="overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800"
            >
                <table
                    class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                >
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300"
                            >
                                Name
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300"
                            >
                                Email
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700"
                    >
                        @foreach ($users as $user)
                        <tr>
                            <td
                                class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-100"
                            >
                                {{ $user->name }}
                            </td>
                            <td
                                class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-300"
                            >
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form
                                    method="POST"
                                    action="{{ route('admin.approve', $user->id) }}"
                                >
                                    @csrf @method('PATCH')
                                    <button
                                        type="submit"
                                        class="font-semibold text-green-600 hover:text-green-900 dark:hover:text-green-400"
                                    >
                                        Approve
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
