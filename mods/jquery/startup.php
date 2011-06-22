<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

# Command order is important: jQuery is last to be loaded at first
cs_scriptload('jquery', 'javascript', 'csp_ajax.js', 1);
cs_scriptload('jquery', 'javascript', 'csp_func.js', 1);
cs_scriptload('jquery', 'javascript', 'jquery.js', 1);