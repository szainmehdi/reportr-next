<div id="actionBar">
    <div id="actionBarContentWrap">
        <a id="refresh" class="actionBarButton" href="index.php">
            <img src="images/actionBar/1_navigation_refresh.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">refresh</span>
        </a>
        <a id="batchClock" class="actionBarButton" href="expressClock.php">
            <img src="images/actionBar/10_device_access_alarms.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">express</span>
        </a>
        <a id="new" class="actionBarButton overflowed" href="javascript:void()" onclick="openBox('newOverflow');">
            <img src="images/actionBar/5_content_new.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">new</span>
        </a>
        <div id="newOverflow" class="actionBarOverflowMenu">
            <a id="newEmployee" class="actionBarButton" href="javascript:void()" onclick="closeBox('newOverflow');openBox('newEmployeeForm');dimActionBar();dimButtonBar();">
                <img src="images/actionBar/6_social_add_person.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">new employee</span>
            </a>
            <a id="newJob" class="actionBarButton" href="javascript:void()" onclick="closeBox('newOverflow');openBox('newJobForm');dimActionBar();dimButtonBar();">
                <img src="images/actionBar/5_content_new_event.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">new job</span>
            </a>
        </div>
        <a id="edit" class="actionBarButton overflowed" href="javascript:void()" onclick="openBox('editOverflow');">
            <img src="images/actionBar/5_content_edit.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">edit</span>
        </a>
        <div id="editOverflow" class="actionBarOverflowMenu" >
            <a id="editEmployee" class="actionBarButton" href="javascript:void()" onclick="closeBox('editOverflow');openBox('editEmployeeForm');dimActionBar();dimButtonBar();">
                <img src="images/actionBar/6_social_person.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">edit an employee</span>
            </a>
            <a id="editJob" class="actionBarButton" href="javascript:void()" onclick="closeBox('editOverflow');openBox('editJobForm');dimActionBar();dimButtonBar();">
                <img src="images/actionBar/5_content_paste.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">edit a job</span>
            </a>
        </div>
        <a id="endJob" class="actionBarButton" href="endJob.php">
            <img src="images/actionBar/5_content_save.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">end job</span>
        </a>
        <a id="showReport" class="actionBarButton" href="javascript:void()" onclick="openBox('createReportForm');dimActionBar();dimButtonBar();">
            <img src="images/actionBar/4_collections_view_as_list.png" width="32" height="32" class="actionBarIcon" /><span class="actionBarButtonText">reports</span>
        </a>
    </div>
</div>
