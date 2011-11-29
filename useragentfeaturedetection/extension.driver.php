<?php

  Class Extension_UserAgentFeatureDetection extends Extension {

    public function about() {
      return array(
        'author'       => array(
          'email'    => 'brian@briandrum.net',
          'name'     => 'Brian Drum',
          'website'  => 'http://briandrum.net'
        ),
        'description'  => 'The User Agent Feature Detection extension makes information about user agent features available in the param pool for the purposes of responsive web design.',
        'name'         => 'User Agent Feature Detection',
        'release-date' => '2011-11-29',
        'version'      => '0.2'
      );
    }

    public function install() {
      Symphony::Configuration()->set('maxwidth_enabled', 'true', 'feature');
      Symphony::Configuration()->set('maxwidth_value', 480, 'feature');
      Administration::instance()->saveConfig();
    }

    public function uninstall() {
      Symphony::Configuration()->remove('feature');
      Administration::instance()->saveConfig();
    }

    public function getSubscribedDelegates(){
      return array(
        array(
          'page'     => '/system/preferences/',
          'delegate' => 'AddCustomPreferenceFieldsets',
          'callback' => 'appendPreferences'
        ),
        array(
          'page'     => '/system/preferences/',
          'delegate' => 'Save',
          'callback' => 'savePreferences'
        ),
        array(
          'page'     => '/frontend/',
          'delegate' => 'FrontendParamsResolve',
          'callback' => 'addParam'
        )
      );
    }

    public function appendPreferences($context) {
      $uafd_fieldset = new XMLElement('fieldset');
      $uafd_fieldset->setAttribute('class', 'settings');
      $uafd_fieldset->appendChild(new XMLElement('legend', __('User Agent Feature Detection')));
      $context['wrapper']->appendChild($uafd_fieldset);

      $maxwidth_div = new XMLElement('div');
      $maxwidth_div->setAttribute('class', 'group');
      $uafd_fieldset->appendChild($maxwidth_div);

      $maxwidth_enabled_current = Symphony::Configuration()->get('maxwidth_enabled', 'feature');
      $maxwidth_enabled_select = Widget::Select('settings[feature][maxwidth_enabled]',
        array(
          array('true', ('true' == $maxwidth_enabled_current) ? true : false, "Enabled"),
          array('false', ('false' == $maxwidth_enabled_current) ? true : false, "Disabled")
        )
      );
      $maxwidth_enabled_label = Widget::Label('Detect Maximum Device Width', $maxwidth_enabled_select);
      $maxwidth_div->appendChild($maxwidth_enabled_label);

      $maxwidth_value_current = Symphony::Configuration()->get('maxwidth_value', 'feature');
      $maxwidth_value_input = Widget::Input('settings[feature][maxwidth_value]', $maxwidth_value_current, 'number',
        array(
          'min'   => 0,
          'step'  => 10
        ));
      $maxwidth_value_label = Widget::Label('Default for user agents that cannot create cookies', $maxwidth_value_input);
      $maxwidth_div->appendChild($maxwidth_value_label);
    }

    public function addParam($context) {

      // detection cookie
      $feature_detection  = !empty($_COOKIE['feature_detection']) ? $_COOKIE['feature_detection'] : 0;
      $context['params']['feature-detection'] = $feature_detection;

      // maxwidth cookie
      if (Symphony::Configuration()->get('maxwidth_enabled', 'feature') === 'true') {
        $feature_maxwidth_fallback = Symphony::Configuration()->get('maxwidth_value', 'feature');
        $feature_maxwidth = !empty($_COOKIE['feature_maxwidth']) ? $_COOKIE['feature_maxwidth'] : $feature_maxwidth_fallback;
        $context['params']['feature-maxwidth'] = $feature_maxwidth;
      }

    }

  }

?>
