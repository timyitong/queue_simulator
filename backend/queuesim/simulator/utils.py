import numpy as np
def randseq(student_num,pvals,n=100):
	rdns = np.random.multinomial(n,pvals,size=student_num)
	print rdns
	students = []
	for student in rdns:
		l = []
		for i in range(len(student)):
			obj = {}
			obj['id'] = i
			obj['value'] = student[i]
			l.append(obj)
		l = sorted(l,key=lambda l: l['value'],reverse=True)
		students.append(l)
	print students
	return rdns
def companyvector(company_array):
	pvals = []
	total_weight = 0
	for item in company_array:
		total_weight = total_weight+item['weight']
	for item in company_array:
		pvals.append(1.0*item['weight']/total_weight)
	return pvals
def actions_seq(rdns,companies):
	return []