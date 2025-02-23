<div class="filament-tables-container rounded-xl border border-gray-300 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <div class="filament-tables-table-container overflow-x-auto">
        <table class="filament-tables-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700">
                    <th class="filament-tables-header-cell px-4 py-2 whitespace-nowrap font-medium text-gray-600 dark:text-gray-300">
                        User
                    </th>
                    <th class="filament-tables-header-cell px-4 py-2 whitespace-nowrap font-medium text-gray-600 dark:text-gray-300">
                        Points
                    </th>
                    <th class="filament-tables-header-cell px-4 py-2 whitespace-nowrap font-medium text-gray-600 dark:text-gray-300">
                        Type
                    </th>
                    <th class="filament-tables-header-cell px-4 py-2 whitespace-nowrap font-medium text-gray-600 dark:text-gray-300">
                        Date
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($getRecord()->points()->with('user')->orderBy('created_at', 'desc')->get() as $point)
                    <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="filament-tables-cell px-4 py-2 align-top">
                            {{ $point->user?->name ?? 'N/A' }}
                        </td>
                        <td class="filament-tables-cell px-4 py-2 align-top">
                            {{ number_format($point->point_value) }}
                        </td>
                        <td class="filament-tables-cell px-4 py-2 align-top">
                            <span class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl text-success-700 bg-success-500/10 dark:text-success-500">
                                {{ $point->point_type }}
                            </span>
                        </td>
                        <td class="filament-tables-cell px-4 py-2 align-top">
                            {{ $point->created_at->format('M d, Y H:i:s') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
