<div class="well well-sm" id="edit_area">
    <form id="user_form" name="user_form">
        <input type="hidden" name="mode" id="mode" value="{$mode}" />
        <dl>
            <dt>{#pref#}</dt>
            <dd>
                <select id="pref_list" name="pref_list">
                    <option value="">--</option>
                    {foreach from=$prefs item=p}
                        <option value="{$p.id}"{if $p.selected|default:0} selected="selected"{/if}>{$p.name}</option>
                    {/foreach}
                </select>
            </dd>
            <dt>{#shop#}</dt>
            <dd>
                <select id="shop_list" name="shop_list">
                    <option value="">--</option>
                    {foreach from=$shops item=s}
                        <option value="{$s.id}"{if $s.selected|default:0} selected="selected"{/if}>{$s.name}</option>
                    {/foreach}
                </select>
            </dd>
            <dt>{#name#}</dt>
            <dd><input type="text" name="name" id="name" value="{$name|default:''}" /></dd>
            <dt>{#staff_code#}</dt>
            <dd><input type="text" name="staff_code" id="staff_code" value="{$staff_code|default:''}" /></dd>
            <dt>{#email#}</dt>
            <dd><input type="text" name="email" id="email" value="{$email|default:''}" /></dd>
            <dt>{#loginname#}</dt>
            <dd><input type="text" name="loginname" id="loginname" value="{$loginname|default:''}" /></dd>
            <dt>{#password#}</dt>
            <dd><input type="text" name="password" id="password" value="{$password|default:''}" /></dd>
            <dt>{#admin#}</dt>
            <dd>
                <label><input type="radio" name="admin" id="admin" value="1"{if $admin|default:0} checked="checked"{/if} />{#admin#}</label>
                <label><input type="radio" name="admin" id="admin" value="0"{if !$admin|default:0} checked="checked"{/if} />{#general#}</label>
            </dd>
            
            <dt>{#on_off#}</dt>
            <dd>
                <label><input type="radio" name="on_off" id="on_off" value="1"{if $on_off|default:1} checked="checked"{/if} />{#on_off#}</label>
                <label><input type="radio" name="on_off" id="on_off" value="0"{if !$on_off|default:1} checked="checked"{/if} />{#off#}</label>
            </dd>
            <dd>
                <a href="#" class="btn btn-sm btn-default" id="cancel_but"><span class="glyphicon glyphicon-remove"></span>&nbsp;{#cancel#}</a>
                <a href="#" class="btn btn-sm btn-primary" id="save_but" style="width: 100px;"><span class="glyphicon glyphicon-ok"></span>&nbsp;{#save#}</a>
            </dd>
        </dl>
    </form>
            <script>
                $(function(){
                    $('#cancel_but').click(function(){
                        $('#edit_area').fadeOut();
                    });
                });
            </script>
</div>