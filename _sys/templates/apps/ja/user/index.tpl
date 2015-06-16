{extends file='index.tpl'}
{block name="admin_active"} active{/block}
{block name="local_css"}user{/block}
{block name="main_content"}

    <div class="row" id="index_user">

        <div class="col-md-8">

            <div class="well well-sm">
                <form>
                    {#filter#}&nbsp;<select id="pref_list" name="pref_list">
                        <option value="">{#pref#}</option>
                        {foreach from=$prefs item=p}
                            <option value="{$p.id}">{$p.name}</option>
                            {/foreach}
                    </select>
                            <a href="#" class="btn btn-sm btn-primary" style="margin-left: 100px;" id="add_new_but"><span class="glyphicon glyphicon-plus"></span>&nbsp;{#add#}</a>
                        
                        </form>
                    </div>
                            {include file="./list.tpl"}
                </div>

                
                <div class="col-md-4" id="right_pane">

                </div>

               
            </div>
                            {/block}
                                {block name="local_javascript"}
   <script src="{$base_path}js/{$lang|default:'ja'}_user.js?var={$timestamp}"></script>
                                {/block}