import numpy as np

def randseq(student_num,pvals,n=100):
	rdns = np.random.multinomial(n,pvals,size=student_num)
	students = []
	for k in range(len(rdns)):
		student  = rdns[k]
		l = []
		for i in range(len(student)):
			obj = {}
			obj['cid'] = i
			obj['sid'] = k
			obj['value'] = student[i]
			l.append(obj)
		l = sorted(l,key=lambda l: l['value'],reverse=True)
		students.append(l)
	print students
	return students

def companyvector(company_array):
	pvals = []
	total_weight = 0
	for item in company_array:
		total_weight = total_weight+item['weight']
	for item in company_array:
		pvals.append(1.0*item['weight']/total_weight)
	return pvals

class Company:
	def __init__(self,speed):
		self.speed = speed
		self.count = 1
		self.queue = []
		self.len = 0
	def enqueue(self,student):
		self.queue.append(student)
		self.len = self.len+1
	def dequeue(self):
		if self.count % self.speed == 0 and len(self.queue) > 0 :
			self.len = self.len-1
			self.count =  self.count+1
			return self.queue.pop(0)
		else:
			self.count =  self.count+1
			return {'sid':-1,'value':-1,'cid':-1}

def actions_seq(rdns,companies):
	# init values
	student_num = len(rdns)
	student_left_num = student_num
	time = 1
	# init Company queues
	coms = []
	for com in companies:
		obj = Company(com['speed'])
		coms.append(obj)
	# init waiting queue
	waiting = Company(1)
	for item in rdns:
		waiting.enqueue(item.pop(0))
	# simulate the process util all done
	action_record = []
	while student_left_num > 0:
		# check each company, whether need proceed
		new_waiting = Company(1)
		for com in coms:
			student = com.dequeue()
			if (student['sid'] != -1):
				sid = student['sid']
				cid = student['cid']
				action = {}
				action['type'] = 'dequeue'
				action['sid'] = sid
				action['cid'] = cid
				action['time'] = time
				# record the action
				print action
				action_record.append(action)
				if (len(rdns[sid]) > 0):
					new_waiting.enqueue(rdns[sid].pop(0))
				else:
					student_left_num = student_left_num-1
		# put waiting things into queue
		while waiting.len > 0:
			student = waiting.dequeue()
			cid = student['cid']
			sid = student['sid']
			com = coms[cid]
			com.enqueue(student)
			#record action
			action = {}
			action['type'] = 'enqueue'
			action['sid'] = sid
			action['cid'] = cid
			action['time'] = time
			print action
			action_record.append(action)
		# reset waiting
		waiting = new_waiting
		time = time+1
	# print action_record
	return action_record