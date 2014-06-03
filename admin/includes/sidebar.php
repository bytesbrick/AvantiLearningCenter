<script type="text/javascript">
    function _chkEnter(ev) {
        var kc = null;
        if (window.event)
            kc = window.event.keyCode;
        else if (ev)
            kc = ev.which;
        if (kc == 13)
        _getsearchdata();
    }
</script>
<div class="sidebar">
    <div class="searchbox">
        <span class="fl smallhead">Search anything &amp; everything</span>
        <input id="txtsearch" class="inputseacrh" type="text" name="txtsearch" placeholder="Search.." style="width: 84.3%;" onkeypress="javascript: _chkEnter(event);" />
        <div class="clr"></div>
        <br />
        <select id="ddlType" class="inputseacrh" type="text" name="ddlType" style="width: 88% !important">
            <option value="all">All</option>
            <option value="curriculums">Curriculums</option>
            <option value="subjects">Subjects</option>
            <option value="chapters">Chapters</option>
            <option value="topics">Topics</option>
            <option value="tags">Tags</option>
            <option value="resources">Resources</option>
            <option value="editors">Editors</option>
            <option value="users">Users</option>
            <option value="tests">Spot/Concept Tests</option>
        </select>   
        <div id="hddnsearchtext"></div>
        <input type="button" name="searchtext" id="searchtext" value="" class="searchimg" onclick="javascript: _getsearchdata(); "/>
    </div>
    <div id="searchData"></div>
</div>