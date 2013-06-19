from django.shortcuts import render, get_object_or_404
from django.http import HttpResponseRedirect, HttpResponse
from django.core.urlresolvers import reverse
import json


def index(request,template_name='simulator/index.html'):
	data = {}
	return render(request, template_name, data)
def simulate(request):
	data = {}
	student_num = request.GET['student_num']
	company_num = request.GET['company_num']
	company_array = request.GET['company_array']
	student_array = request.GET['student_array']
	return HttpResponse(json.dumps(data), mimetype='application/json')