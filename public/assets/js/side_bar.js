var html ='';
html +='            <div class="navbar-default sidebar" role="navigation">';
html +='                <div class="sidebar-nav navbar-collapse">';
html +='                    <ul class="nav" id="side-menu">';
html +='                        <li>';
html +='                            <a href="/"><i class="fa fa-dashboard fa-fw"></i>ホーム</a>';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="#"><i class="fa fa-user fa-fw"></i>顧客管理<span class="fa arrow"></span></a>';
html +='                            <ul class="nav nav-second-level">';
html +='                                <li>';
html +='                                    <a href="/customer/search.html">顧客情報</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/tmpcustomer/tmpsearch.html">口座開設管理</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/tmpcustomer/tmpregist.html">口座開設登録</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/tmpcustomer/depositaccount.html">入金口座登録</a>';
html +='                                </li>';
html +='                            </ul>';
html +='                            <!-- /.nav-second-level -->';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="#"><i class="fa fa-briefcase fa-fw"></i>業務管理<span class="fa arrow"></span></a>';
html +='                            <ul class="nav nav-second-level">';
html +='                                <li>';
html +='                                    <a href="/operation/deposit.html">入金処理</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/operation/withdraw.html">出金依頼</a>';
html +='                                </li>';
html +='                            </ul>';
html +='                            <!-- /.nav-second-level -->';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="/files/filesupload.html"><i class="fa fa-file-text fa-fw"></i>書面管理</a>';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="#"><i class="fa fa-send fa-fw"></i>お知らせ管理<span class="fa arrow"></span></a>';
html +='                            <ul class="nav nav-second-level">';
html +='                                <li>';
html +='                                    <a href="/info/inforegist.html">お知らせ登録</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/info/infosearch.html">お知らせ検索</a>';
html +='                                </li>';
html +='                            </ul>';
html +='                            <!-- /.nav-second-level -->';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="/question/question.html"><i class="fa fa-question fa-fw"></i>お問い合わせ管理</a>';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="#"><i class="fa fa-info fa-fw"></i>照会<span class="fa arrow"></span></a>';
html +='                            <ul class="nav nav-second-level">';
html +='                                <li>';
html +='                                    <a href="/inquiry/trade_list.html">取引履歴</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/inquiry/cash_balance_list.html">現金残高照会</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/inquiry/stock_balance_list.html">株式残高照会</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/inquiry/ca_detail_list.html">権利詳細照会</a>';
html +='                                </li>';
html +='                            </ul>';
html +='                            <!-- /.nav-second-level -->';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>ＣＡ管理<span class="fa arrow"></span></a>';
html +='                            <ul class="nav nav-second-level">';
html +='                                <li>';
html +='                                    <a href="/ca/haito.html">配当登録</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/ca/bunkatsu.html">分割登録</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/ca/bunkatsu.html">併合登録</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/ca/furiwake.html">その他金額振分登録</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/ca/casearch.html">ＣＡ検索</a>';
html +='                                </li>';
html +='                            </ul>';
html +='                            <!-- /.nav-second-level -->';
html +='                        </li>';
html +='                        <li>';
html +='                            <a href="#"><i class="fa fa-home fa-fw"></i>設定管理<span class="fa arrow"></span></a>';
html +='                            <ul class="nav nav-second-level">';
html +='                                <li>';
html +='                                    <a href="/ourcompany/ourposition.html">銘柄別自己ポジション管理</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/ourcompany/config.html">共通設定変更</a>';
html +='                                </li>';
html +='                                <li>';
html +='                                    <a href="/ourcompany/brandimage.html">銘柄情報管理</a>';
html +='                                </li>';
html +='                            </ul>';
html +='                            <!-- /.nav-second-level -->';
html +='                        </li>';
html +='                    </ul>';
html +='                </div>';
html +='                <!-- /.sidebar-collapse -->';
html +='            </div>';
html +='            <!-- /.navbar-static-side -->';
document.write(html);