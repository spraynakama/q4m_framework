{extends file='index.tpl'}
{block name="home_active"} active{/block}
{block name="main_content"}

            <div class="row" id="index_main">

                <div class="col-md-4">
                    <div class="jumbotron jumbotron-condensed" style=" background-color: #dda0dd; background-image: url(/images/user-group.png); background-repeat: no-repeat; text-align: right; height: 150px;">
                        
                        <h2>顧客分析</h2>
                        
                    </div>

                </div>

                
                <div class="col-md-4">
                      <div class="jumbotron jumbotron-condensed" style="background-color: #dda0dd; background-image: url(/images/shop.png); background-repeat: no-repeat; text-align: right; height: 150px;">
                        <h2>サロン分析</h2>
                        
                    </div>

                </div>
                
                <div class="col-md-4">
                    <div class="jumbotron jumbotron-condensed" style=" background-color: #dda0dd; background-image: url(/images/hairdress.png); background-repeat: no-repeat; text-align: right; height: 150px;">

                        <h2>担当分析</h2>
                        
                    </div>

                </div>

               
            </div>
{/block}
{block name="local_javascript"}
   <script src="{$base_path}js/{$lang|default:'ja'}_index.js?var={$timestamp}"></script>
{/block}