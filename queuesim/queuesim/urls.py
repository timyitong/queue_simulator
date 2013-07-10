from django.conf.urls import patterns, include, url

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    url(r'^$', 'queuesim.views.home', name='home'),
    # url(r'^queuesim/', include('queuesim.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # url(r'^admin/', include(admin.site.urls)),
    url(r'^simulate/','simulator.views.simulate',name='simulate'),
    url(r'^simulator/','simulator.views.index',name='index'),
    url(r'^simulator/test','simulator.views.test_console',name='test_console'),
)
