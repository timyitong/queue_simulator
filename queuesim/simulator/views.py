from django.shortcuts import render, get_object_or_404
from django.http import HttpResponseRedirect, HttpResponse
from django.core.urlresolvers import reverse
from simulator.utils import randseq
from simulator.utils import companyvector
from simulator.utils import actions_seq
from StringIO import StringIO
import json


def index(request,template_name='simulator/index.html'):
	data = {}
	return render(request, template_name, data)

def test_console(request,template_name='simulator/test_console.html'):
	data = {}
	return render(request, template_name, data)

def simulate(request):
	data = {}
	json_obj = json.loads(request.POST['json_data'])
	student_num = json_obj['student_num']
	company_num = json_obj['company_num']
	companies = json_obj['companies']
	students = json_obj['students']
	vec = companyvector(companies)
	# Get all student squences
	rdns = randseq(student_num,vec)
	data['json_data'] = json.dumps(actions_seq(rdns,companies))
	return HttpResponse(json.dumps(data), mimetype='application/json')