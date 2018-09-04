<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevDebugProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        // gesdinet_jwt_refresh_token
        if ($pathinfo === '/api/token/refresh') {
            return array (  '_controller' => 'gesdinet.jwtrefreshtoken:refresh',  '_route' => 'gesdinet_jwt_refresh_token',);
        }

        // login
        if ($pathinfo === '/login') {
            return array (  '_controller' => 'AppBundle\\Controller\\AuthController::loginAction',  '_route' => 'login',);
        }

        // ecwid_login
        if ($pathinfo === '/ecwid_login') {
            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::ecwid_login',  '_route' => 'ecwid_login',);
        }

        // logout
        if ($pathinfo === '/logout') {
            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::logout',  '_route' => 'logout',);
        }

        // profile_edit
        if ($pathinfo === '/profile/edit') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_profile_edit;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\ProfileController::postSaveProfile',  '_route' => 'profile_edit',);
        }
        not_profile_edit:

        if (0 === strpos($pathinfo, '/register')) {
            // fb_register
            if ($pathinfo === '/register/facebook') {
                return array (  '_controller' => 'AppBundle\\Controller\\SignupController::facebookAction',  '_route' => 'fb_register',);
            }

            // google_register
            if ($pathinfo === '/register/google') {
                return array (  '_controller' => 'AppBundle\\Controller\\SignupController::googleAction',  '_route' => 'google_register',);
            }

        }

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/log')) {
                if (0 === strpos($pathinfo, '/api/login')) {
                    // api_login_google
                    if ($pathinfo === '/api/login/google') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_login_google;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\AuthenticationController::googleLoginAction',  '_route' => 'api_login_google',);
                    }
                    not_api_login_google:

                    // api_login_facebook
                    if ($pathinfo === '/api/login/facebook') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_login_facebook;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\AuthenticationController::facebookLoginAction',  '_route' => 'api_login_facebook',);
                    }
                    not_api_login_facebook:

                    // api_login
                    if ($pathinfo === '/api/login') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_login;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\AuthenticationController::loginAction',  '_route' => 'api_login',);
                    }
                    not_api_login:

                }

                // api_logout
                if ($pathinfo === '/api/logout') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_logout;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\AuthenticationController::logoutAction',  '_route' => 'api_logout',);
                }
                not_api_logout:

            }

            // api_logout_rest
            if ($pathinfo === '/api/rest') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_api_logout_rest;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\AuthenticationController::restAction',  '_route' => 'api_logout_rest',);
            }
            not_api_logout_rest:

            if (0 === strpos($pathinfo, '/api/a')) {
                // api_ecwid_login
                if ($pathinfo === '/api/api_ecwid_login') {
                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\AuthenticationController::api_ecwid_login',  '_route' => 'api_ecwid_login',);
                }

                if (0 === strpos($pathinfo, '/api/avgtraining')) {
                    // api_post_avg_trainings
                    if ($pathinfo === '/api/avgtraining/upload') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_avg_trainings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\AvgTrainingController::postAvgTraining',  '_route' => 'api_post_avg_trainings',);
                    }
                    not_api_post_avg_trainings:

                    // api_get_all_avg_trainings
                    if ($pathinfo === '/api/avgtraining/download') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_get_all_avg_trainings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\AvgTrainingController::getAvgTrainings',  '_route' => 'api_get_all_avg_trainings',);
                    }
                    not_api_get_all_avg_trainings:

                    // api_get_avg_trainings
                    if (preg_match('#^/api/avgtraining/(?P<sessionid>\\d+)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_get_avg_trainings;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_get_avg_trainings')), array (  '_controller' => 'AppBundle\\Controller\\Api\\AvgTrainingController::getAvgTraining',));
                    }
                    not_api_get_avg_trainings:

                    // api_delete_avg_training
                    if ($pathinfo === '/api/avgtraining/delete') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_delete_avg_training;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\AvgTrainingController::deleteTraining',  '_route' => 'api_delete_avg_training',);
                    }
                    not_api_delete_avg_training:

                }

            }

            if (0 === strpos($pathinfo, '/api/event')) {
                if (0 === strpos($pathinfo, '/api/event/d')) {
                    // api_get_event_days
                    if ($pathinfo === '/api/event/days') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_get_event_days;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\EventController::getDays',  '_route' => 'api_get_event_days',);
                    }
                    not_api_get_event_days:

                    // api_get_events_by_timestamp
                    if ($pathinfo === '/api/event/downloadByTimestamp') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_get_events_by_timestamp;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\EventController::downloadByTimestamp',  '_route' => 'api_get_events_by_timestamp',);
                    }
                    not_api_get_events_by_timestamp:

                }

                // api_post_events
                if ($pathinfo === '/api/event/upload') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_events;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\EventController::upload',  '_route' => 'api_post_events',);
                }
                not_api_post_events:

                // api_edit_event
                if ($pathinfo === '/api/event/edit') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_edit_event;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\EventController::edit',  '_route' => 'api_edit_event',);
                }
                not_api_edit_event:

                // api_delete_event
                if ($pathinfo === '/api/event/delete') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_delete_event;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\EventController::delete',  '_route' => 'api_delete_event',);
                }
                not_api_delete_event:

            }

            // api_upload_log
            if ($pathinfo === '/api/uploadLog') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_api_upload_log;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\LogController::uploadLog',  '_route' => 'api_upload_log',);
            }
            not_api_upload_log:

            if (0 === strpos($pathinfo, '/api/a')) {
                // api_contact_us
                if ($pathinfo === '/api/api_contact_us') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_contact_us;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\MailController::contactEmailAction',  '_route' => 'api_contact_us',);
                }
                not_api_contact_us:

                if (0 === strpos($pathinfo, '/api/avgtraining')) {
                    // api_upload_avg_trainings
                    if ($pathinfo === '/api/avgtraining/uploadAvgTrainings') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_upload_avg_trainings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\NewTrainingAvgController::uploadAvgTrainings',  '_route' => 'api_upload_avg_trainings',);
                    }
                    not_api_upload_avg_trainings:

                    // api_download_avg_by_session_ids
                    if ($pathinfo === '/api/avgtraining/downloadBySessionIds') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_download_avg_by_session_ids;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\NewTrainingAvgController::downloadBySessionIds',  '_route' => 'api_download_avg_by_session_ids',);
                    }
                    not_api_download_avg_by_session_ids:

                }

            }

            if (0 === strpos($pathinfo, '/api/training')) {
                // api_upload_trainings
                if ($pathinfo === '/api/training/uploadTrainings') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_upload_trainings;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\NewTrainingController::uploadTrainings',  '_route' => 'api_upload_trainings',);
                }
                not_api_upload_trainings:

                if (0 === strpos($pathinfo, '/api/training/download')) {
                    // api_download_by_session_ids
                    if ($pathinfo === '/api/training/downloadBySessionIds') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_download_by_session_ids;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\NewTrainingController::downloadBySessionIds',  '_route' => 'api_download_by_session_ids',);
                    }
                    not_api_download_by_session_ids:

                    // api_download_days
                    if ($pathinfo === '/api/training/downloadDays') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_download_days;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\NewTrainingController::downloadDays',  '_route' => 'api_download_days',);
                    }
                    not_api_download_days:

                }

            }

            if (0 === strpos($pathinfo, '/api/plan')) {
                if (0 === strpos($pathinfo, '/api/plan/downloadBy')) {
                    // api_get_plan_by_name
                    if ($pathinfo === '/api/plan/downloadByName') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_get_plan_by_name;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanController::downloadByName',  '_route' => 'api_get_plan_by_name',);
                    }
                    not_api_get_plan_by_name:

                    // api_get_plan_by_id
                    if ($pathinfo === '/api/plan/downloadById') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_get_plan_by_id;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanController::downloadById',  '_route' => 'api_get_plan_by_id',);
                    }
                    not_api_get_plan_by_id:

                }

                // api_post_plans
                if ($pathinfo === '/api/plan/upload') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_plans;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanController::upload',  '_route' => 'api_post_plans',);
                }
                not_api_post_plans:

                // api_edit_plan
                if ($pathinfo === '/api/plan/edit') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_edit_plan;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanController::edit',  '_route' => 'api_edit_plan',);
                }
                not_api_edit_plan:

                // api_delete_plan
                if ($pathinfo === '/api/plan/delete') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_delete_plan;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanController::delete',  '_route' => 'api_delete_plan',);
                }
                not_api_delete_plan:

                if (0 === strpos($pathinfo, '/api/planTraining')) {
                    if (0 === strpos($pathinfo, '/api/planTraining/downloadBySessionId')) {
                        // api_get_plantrainings_by_sessionid
                        if ($pathinfo === '/api/planTraining/downloadBySessionId') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_api_get_plantrainings_by_sessionid;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanTrainingController::downloadBySessionId',  '_route' => 'api_get_plantrainings_by_sessionid',);
                        }
                        not_api_get_plantrainings_by_sessionid:

                        // api_get_plantrainings_by_sessionids
                        if ($pathinfo === '/api/planTraining/downloadBySessionIds') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_api_get_plantrainings_by_sessionids;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanTrainingController::downloadBySessionIds',  '_route' => 'api_get_plantrainings_by_sessionids',);
                        }
                        not_api_get_plantrainings_by_sessionids:

                    }

                    // api_post_plantrainings
                    if ($pathinfo === '/api/planTraining/upload') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_plantrainings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanTrainingController::upload',  '_route' => 'api_post_plantrainings',);
                    }
                    not_api_post_plantrainings:

                    // api_delete_plantraining
                    if ($pathinfo === '/api/planTraining/delete') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_delete_plantraining;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\PlanTrainingController::delete',  '_route' => 'api_delete_plantraining',);
                    }
                    not_api_delete_plantraining:

                }

            }

            // api_signup
            if ($pathinfo === '/api/register') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_api_signup;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\SignUpController::signupAction',  '_route' => 'api_signup',);
            }
            not_api_signup:

            if (0 === strpos($pathinfo, '/api/training')) {
                // api_upload_sum_trainings
                if ($pathinfo === '/api/training/uploadSumTrainings') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_upload_sum_trainings;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\SumTrainingController::uploadSumTrainings',  '_route' => 'api_upload_sum_trainings',);
                }
                not_api_upload_sum_trainings:

                if (0 === strpos($pathinfo, '/api/training/download')) {
                    // api_download_sum_trainings
                    if ($pathinfo === '/api/training/downloadSumTrainings') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_download_sum_trainings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\SumTrainingController::downloadSumTrainings',  '_route' => 'api_download_sum_trainings',);
                    }
                    not_api_download_sum_trainings:

                    // api_get_trainings
                    if ($pathinfo === '/api/training/download') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_get_trainings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\TrainingController::getTrainings',  '_route' => 'api_get_trainings',);
                    }
                    not_api_get_trainings:

                }

                // api_post_trainings
                if ($pathinfo === '/api/training/upload') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_trainings;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\TrainingController::postTrainings',  '_route' => 'api_post_trainings',);
                }
                not_api_post_trainings:

                if (0 === strpos($pathinfo, '/api/training/d')) {
                    // api_get_training_days
                    if ($pathinfo === '/api/training/days') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_api_get_training_days;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\TrainingController::getTrainingDays',  '_route' => 'api_get_training_days',);
                    }
                    not_api_get_training_days:

                    // api_delete_training
                    if ($pathinfo === '/api/training/delete') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_delete_training;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\TrainingController::delete',  '_route' => 'api_delete_training',);
                    }
                    not_api_delete_training:

                }

            }

            if (0 === strpos($pathinfo, '/api/users')) {
                // api_get_current_user
                if ($pathinfo === '/api/users/current') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_api_get_current_user;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::getCurrentUserAction',  '_route' => 'api_get_current_user',);
                }
                not_api_get_current_user:

                // api_post_update_current_user
                if ($pathinfo === '/api/users/update') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_update_current_user;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::postUpdateCurrentUserAction',  '_route' => 'api_post_update_current_user',);
                }
                not_api_post_update_current_user:

                if (0 === strpos($pathinfo, '/api/users/p')) {
                    // api_post_update_current_user_password
                    if ($pathinfo === '/api/users/password/update') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_update_current_user_password;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::postPasswordUpdate',  '_route' => 'api_post_update_current_user_password',);
                    }
                    not_api_post_update_current_user_password:

                    // api_post_pw_reset_request
                    if ($pathinfo === '/api/users/pwreset') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_api_post_pw_reset_request;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::postPwResetRequestCurrentUserAction',  '_route' => 'api_post_pw_reset_request',);
                    }
                    not_api_post_pw_reset_request:

                }

                // api_post_push_id
                if ($pathinfo === '/api/users/uploadPushId') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_push_id;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::uploadPushId',  '_route' => 'api_post_push_id',);
                }
                not_api_post_push_id:

                // api_post_push_notification_self
                if ($pathinfo === '/api/users/testPushNotification') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_push_notification_self;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::testPushNotification',  '_route' => 'api_post_push_notification_self',);
                }
                not_api_post_push_notification_self:

                // api_post_broadcast_push
                if ($pathinfo === '/api/users/broadcastPush') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_post_broadcast_push;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::broadcastPush',  '_route' => 'api_post_broadcast_push',);
                }
                not_api_post_broadcast_push:

                // api_get_message
                if ($pathinfo === '/api/users/getMessage') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_api_get_message;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::getMessage',  '_route' => 'api_get_message',);
                }
                not_api_get_message:

            }

            // api_get_version
            if ($pathinfo === '/api/version') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_api_get_version;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\VersionController::getVersion',  '_route' => 'api_get_version',);
            }
            not_api_get_version:

        }

        if (0 === strpos($pathinfo, '/webapi')) {
            if (0 === strpos($pathinfo, '/webapi/avgtraining')) {
                // webapi_post_avg_trainings
                if ($pathinfo === '/webapi/avgtraining/upload') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_webapi_post_avg_trainings;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\AvgTrainingController::postAvgTraining',  '_route' => 'webapi_post_avg_trainings',);
                }
                not_webapi_post_avg_trainings:

                // webapi_get_all_avg_trainings
                if ($pathinfo === '/webapi/avgtraining/download') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_webapi_get_all_avg_trainings;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\AvgTrainingController::getAvgTrainings',  '_route' => 'webapi_get_all_avg_trainings',);
                }
                not_webapi_get_all_avg_trainings:

                // webapi_get_avg_trainings
                if (preg_match('#^/webapi/avgtraining/(?P<sessionid>\\d+)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_webapi_get_avg_trainings;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'webapi_get_avg_trainings')), array (  '_controller' => 'AppBundle\\Controller\\Web\\AvgTrainingController::getAvgTraining',));
                }
                not_webapi_get_avg_trainings:

            }

            if (0 === strpos($pathinfo, '/webapi/training')) {
                if (0 === strpos($pathinfo, '/webapi/training/download')) {
                    // webapi_get_training_avgs
                    if ($pathinfo === '/webapi/training/downloadavg') {
                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\TrainingController::getTrainingAvgs',  '_route' => 'webapi_get_training_avgs',);
                    }

                    // webapi_get_trainings
                    if ($pathinfo === '/webapi/training/download') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_webapi_get_trainings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\TrainingController::getTrainings',  '_route' => 'webapi_get_trainings',);
                    }
                    not_webapi_get_trainings:

                }

                // webapi_post_trainings
                if ($pathinfo === '/webapi/training/upload') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_webapi_post_trainings;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\TrainingController::postTrainings',  '_route' => 'webapi_post_trainings',);
                }
                not_webapi_post_trainings:

                // webapi_get_training_days
                if ($pathinfo === '/webapi/training/days') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_webapi_get_training_days;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\TrainingController::getTrainingDays',  '_route' => 'webapi_get_training_days',);
                }
                not_webapi_get_training_days:

            }

            if (0 === strpos($pathinfo, '/webapi/users')) {
                // webapi_get_current_user
                if ($pathinfo === '/webapi/users/current') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_webapi_get_current_user;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\UserController::getCurrentUserAction',  '_route' => 'webapi_get_current_user',);
                }
                not_webapi_get_current_user:

                // webapi_post_update_current_user
                if ($pathinfo === '/webapi/users/update') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_webapi_post_update_current_user;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\UserController::postUpdateCurrentUserAction',  '_route' => 'webapi_post_update_current_user',);
                }
                not_webapi_post_update_current_user:

                if (0 === strpos($pathinfo, '/webapi/users/p')) {
                    // webapi_post_update_current_user_password
                    if ($pathinfo === '/webapi/users/password/update') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_webapi_post_update_current_user_password;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\UserController::postPasswordUpdate',  '_route' => 'webapi_post_update_current_user_password',);
                    }
                    not_webapi_post_update_current_user_password:

                    // webapi_post_pw_reset_request
                    if ($pathinfo === '/webapi/users/pwreset') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_webapi_post_pw_reset_request;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\UserController::postPwResetRequestCurrentUserAction',  '_route' => 'webapi_post_pw_reset_request',);
                    }
                    not_webapi_post_pw_reset_request:

                }

            }

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'fos_user.security.controller:loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'fos_user.security.controller:checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'fos_user.security.controller:logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'fos_user.profile.controller:showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'fos_user.profile.controller:editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/register') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_registration_register;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'fos_user.registration.controller:registerAction',  '_route' => 'fos_user_registration_register',);
                }
                not_fos_user_registration_register:

                if (0 === strpos($pathinfo, '/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'fos_user.registration.controller:checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'fos_user.registration.controller:confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'fos_user.registration.controller:confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'fos_user.resetting.controller:requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ($pathinfo === '/resetting/send-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'fos_user.resetting.controller:sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ($pathinfo === '/resetting/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'fos_user.resetting.controller:checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'fos_user.resetting.controller:resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        // fos_user_change_password
        if ($pathinfo === '/profile/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }

            return array (  '_controller' => 'fos_user.change_password.controller:changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        if (0 === strpos($pathinfo, '/connect')) {
            // hwi_oauth_service_redirect
            if (preg_match('#^/connect/(?P<service>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'hwi_oauth_service_redirect')), array (  '_controller' => 'HWI\\Bundle\\OAuthBundle\\Controller\\ConnectController::redirectToServiceAction',));
            }

            // hwi_oauth_connect_service
            if (0 === strpos($pathinfo, '/connect/service') && preg_match('#^/connect/service/(?P<service>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'hwi_oauth_connect_service')), array (  '_controller' => 'HWI\\Bundle\\OAuthBundle\\Controller\\ConnectController::connectServiceAction',));
            }

            // hwi_oauth_connect_registration
            if (0 === strpos($pathinfo, '/connect/registration') && preg_match('#^/connect/registration/(?P<key>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'hwi_oauth_connect_registration')), array (  '_controller' => 'HWI\\Bundle\\OAuthBundle\\Controller\\ConnectController::registrationAction',));
            }

        }

        if (0 === strpos($pathinfo, '/login')) {
            // hwi_oauth_connect
            if (rtrim($pathinfo, '/') === '/login') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'hwi_oauth_connect');
                }

                return array (  '_controller' => 'HWI\\Bundle\\OAuthBundle\\Controller\\ConnectController::connectAction',  '_route' => 'hwi_oauth_connect',);
            }

            if (0 === strpos($pathinfo, '/login/check-')) {
                // facebook_login
                if ($pathinfo === '/login/check-facebook') {
                    return array('_route' => 'facebook_login');
                }

                // google_login
                if ($pathinfo === '/login/check-google') {
                    return array('_route' => 'google_login');
                }

            }

        }

        // app_firebase_login_new
        if ($pathinfo === '/firebase/login') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_app_firebase_login_new;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\Firebase\\LoginController::newAction',  '_route' => 'app_firebase_login_new',);
        }
        not_app_firebase_login_new:

        if (0 === strpos($pathinfo, '/logout_user')) {
            // app_firebase_logout_logout
            if ($pathinfo === '/logout_user') {
                return array (  '_controller' => 'AppBundle\\Controller\\Firebase\\LogoutController::logoutAction',  '_route' => 'app_firebase_logout_logout',);
            }

            // logout_user
            if ($pathinfo === '/logout_user') {
                return array (  '_controller' => 'AppBundle:Controller:Firebase:LogoutController:logout',  '_route' => 'logout_user',);
            }

        }

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        // shop
        if ($pathinfo === '/shop') {
            return array (  '_controller' => 'AppBundle\\Controller\\Shop\\ShopController::indexAction',  '_route' => 'shop',);
        }

        // contact_us_email
        if ($pathinfo === '/v2/contact_us_email') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_contact_us_email;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\V2\\V2Controller::contactEmailAction',  '_route' => 'contact_us_email',);
        }
        not_contact_us_email:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
