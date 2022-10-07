<!-- Sidebar-right-->
<div class="sidebar sidebar-right sidebar-animate">
    <div class="panel panel-primary card mb-0 box-shadow">
        <div class="tab-menu-heading card-img-top-1 border-0 p-3">
            <div class="card-title mb-0">Pengaturan</div>
            <div class="card-options ms-auto">
                <a href="javascript:void(0);" class="sidebar-remove"><i class="fe fe-x"></i></a>
            </div>
        </div>
        <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
            <div class="swichermainleft text-center">
                <h4 class="con-tittle">Situs</h4>
                <div class="skin-body border-bottom" style="padding-bottom: 10px">
                    <select class="form-control select2-situs" id="selectSitus">
                        <option></option>
                    </select>
                </div>
            </div>
            <div id="areaPengaturan">
                <div class="tabs-menu">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs justify-content-between">
                        <li style="width: 49%">
                            <a href="#desktop" class="active w-100 text-center" data-bs-toggle="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pc-display-horizontal side-menu__icon" viewBox="0 0 16 16">
                                    <path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0h-13Zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5ZM12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0ZM1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1ZM1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25Z"/>
                                </svg>
                                Desktop
                            </a>
                        </li>
                        <li style="width: 49%">
                            <a href="#mobile" data-bs-toggle="tab" class="w-100 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone side-menu__icon" viewBox="0 0 16 16">
                                    <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                                    <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                                Mobile
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active " id="desktop">
                        <form id="formDesktop" enctype="multipart/form-data">
                            <div class="swichermainleft text-center">
                                <h4 class="d-flex justify-content-between" >
                                    PROMOSI
                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-promosi" role="button" aria-expanded="false" aria-controls="coll-promosi">
                                        <input type="checkbox" name="promosi" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                    </label>
                                </h4>
                                <div class="skin-body collapse" id="coll-promosi">
                                    <div class="switch_section">
                                        <div class="main-form-group">
                                            <label class="form-label mt-0 text-start">Nama</label>
                                            <input class="form-control" placeholder="Masukan Nama Promosi" type="text" name="namaPromosi">
                                        </div>
                                        <div class="main-form-group mt-2">
                                            <label class="form-label mt-0 text-start">URL</label>
                                            <input class="form-control" placeholder="Masukan URL Promosi" type="text" name="urlPromosi">
                                        </div>
                                        <div class="main-form-group mt-2">
                                            <label class="form-label mt-0 text-start">Image</label>
                                            <input class="form-control" type="file" name="imagePromosi">
                                        </div>
                                        <div id="previewImagePromosi" class="mt-2 d-none">
                                            <img src="#" style="max-height: 200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swichermainleft text-center">
                                <h4 class="d-flex justify-content-between">
                                    LINK ALTERNATIF
                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-link-alter" role="button" aria-expanded="false" aria-controls="desktop">
                                        <input type="checkbox" name="linkAlter" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                    </label>
                                </h4>
                                <div class="skin-body collapse" id="coll-link-alter">
                                    <div class="switch_section">
                                        <div class="main-form-group mt-2">
                                            <label class="form-label mt-0 text-start">Image</label>
                                            <input class="form-control" type="file" name="imageAlter">
                                        </div>

                                        <div class="main-form-group mt-2">
                                            <label class="form-label mt-0 text-start">URL</label>
                                            <textarea class="form-control" placeholder="Masukan URL Promosi" name="urlAlter"></textarea>
                                        </div>
                                        <div class="text-start">
                                            <small class="text-warning fw-bold">Info: untuk memisahkan link silahkan beri tanda '|' tanpa tanda kutip.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100 mx-2">
                                <button type="submit" class="btn btn-primary-light w-100 mt-2">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane  " id="mobile">
                        disni mobile
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/Sidebar-right-->
