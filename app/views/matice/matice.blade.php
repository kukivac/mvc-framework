{extends "../@layout.latte"}
{block content}
    {foreach $tables as $key => $table}
        <h2>{$key}</h2>
        <table>
            <tbody>
            {foreach $table as $item}
                <tr>
                    {foreach $item as $subitem}
                        <td>
                            {$subitem}
                        </td>
                    {/foreach}
                </tr>
            {/foreach}
            </tbody>
        </table>
    {/foreach}
{/block}