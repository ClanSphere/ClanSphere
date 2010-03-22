<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$data = array();

$data['if']['old_php'] = version_compare(phpversion(), 5, '<');

echo cs_subtemplate(__FILE__, $data, 'clansphere', 'charset');