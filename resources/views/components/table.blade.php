<div class="align-middle min-w-full overflow-y-hidden overflow-x-auto bg-white">

    <table {{ $attributes->merge(['class' => 'w-full divide-y divide-gray-200 divide-dashed']) }}>

        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200 divide-dashed">
            {{ $body }}
        </tbody>

    </table>

</div>
