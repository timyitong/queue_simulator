from django.shortcuts import render, get_object_or_404
from django.http import HttpResponseRedirect, HttpResponse
from django.core.urlresolvers import reverse
from StringIO import StringIO
import json


def home(request,template_name='queuesim/index.html'):
	data = {}
	return render(request, template_name, data)