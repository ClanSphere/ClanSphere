<?php

# Command order is important: jQuery is last to be loaded at first
cs_scriptload('jquery', 'javascript', 'csp_ajax.js', 1);
cs_scriptload('jquery', 'javascript', 'csp_func.js', 1);
cs_scriptload('jquery', 'javascript', 'js/jquery.min.js', 1);
