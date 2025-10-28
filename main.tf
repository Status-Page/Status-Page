provider "aws" {
  region = "us-east-1"
}

# create VPC
resource "aws_vpc" "main_vpc" {
  cidr_block = "10.0.0.0/16"

  tags = {
    Name = "main_vpc_nk"
    owner = "meitaveini"
  }
}

# create Private Subnet 1 new
resource "aws_subnet" "private_subnet_1" {
  vpc_id                  = aws_vpc.main_vpc.id
  cidr_block              = "10.0.1.0/24"
  availability_zone       = "us-east-1a"
  map_public_ip_on_launch = false

  tags = {
    Name = "PrivateSubnet1"
    owner = "meitaveini"
  }
}

# create Private Subnet 2 new
resource "aws_subnet" "private_subnet_2" {
  vpc_id                  = aws_vpc.main_vpc.id
  cidr_block              = "10.0.2.0/24"
  availability_zone       = "us-east-1e"
  map_public_ip_on_launch = false

  tags = {
    Name = "PrivateSubnet2"
    owner = "meitaveini"
  }
}

# create Public Subnet 1 new
resource "aws_subnet" "public_subnet_1" {
  vpc_id                  = aws_vpc.main_vpc.id
  cidr_block              = "10.0.3.0/24"
  availability_zone       = "us-east-1a"
  map_public_ip_on_launch = true

  tags = {
    Name = "PublicSubnet1"
    owner = "meitaveini"
  }
}

# create Public Subnet 2 new
resource "aws_subnet" "public_subnet_2" {
  vpc_id                  = aws_vpc.main_vpc.id
  cidr_block              = "10.0.4.0/24"
  availability_zone       = "us-east-1e"
  map_public_ip_on_launch = true

  tags = {
    Name = "PublicSubnet2"
    owner = "meitaveini"
  }
}

# create Internet Gateway
resource "aws_internet_gateway" "main_igw" {
  vpc_id = aws_vpc.main_vpc.id

  tags = {
    Name = "MainInternetGateway"
    owner = "meitaveini"
  }
}
# attached Elastic IP
resource "aws_eip" "nat_eip" {
  domain = "vpc"
}

# create NAT Gateway in-Public Subnet
resource "aws_nat_gateway" "nat_gw" {
  allocation_id = aws_eip.nat_eip.id
  subnet_id     = aws_subnet.public_subnet_1.id 

  tags = {
    Name = "NAT-Gateway"
    owner = "meitaveini"
  }
}

# connect Internet Gateway to-Route Table ofPublic Subnets
resource "aws_route_table" "public_rt" {
  vpc_id = aws_vpc.main_vpc.id

  tags = {
    Name = "Public-RT"
    owner = "meitaveini"
  }
}

# IGW
resource "aws_route" "internet_access" {
  route_table_id         = aws_route_table.public_rt.id
  destination_cidr_block = "0.0.0.0/0"
  gateway_id             = aws_internet_gateway.main_igw.id
}

# route_table
resource "aws_route_table" "private_rt" {
  vpc_id = aws_vpc.main_vpc.id

  tags = {
    Name = "Private-RT"
    owner = "meitaveini"
  }
}

# create NAT Gateway
resource "aws_route" "private_to_nat" {
  route_table_id         = aws_route_table.private_rt.id
  destination_cidr_block = "0.0.0.0/0"
  nat_gateway_id         = aws_nat_gateway.nat_gw.id
}

resource "aws_route_table_association" "public_subnet_1_association" {
  subnet_id      = aws_subnet.public_subnet_1.id
  route_table_id = aws_route_table.public_rt.id
}

resource "aws_route_table_association" "public_subnet_2_association" {
  subnet_id      = aws_subnet.public_subnet_2.id
  route_table_id = aws_route_table.public_rt.id
}

resource "aws_route_table_association" "private_subnet_1_association" {
  subnet_id      = aws_subnet.private_subnet_1.id
  route_table_id = aws_route_table.private_rt.id
}

resource "aws_route_table_association" "private_subnet_2_association" {
  subnet_id      = aws_subnet.private_subnet_2.id
  route_table_id = aws_route_table.private_rt.id
}

# Security Group for-Bastion
resource "aws_security_group" "bastion_sg" {
  vpc_id = aws_vpc.main_vpc.id

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"] 
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

# create Bastion Host
resource "aws_instance" "bastion_host" {
  ami                         = "ami-084568db4383264d4" # Ubuntu 24.04
  instance_type               = "t2.micro"
  subnet_id                   = aws_subnet.public_subnet_1.id
  security_groups             = [aws_security_group.bastion_sg.id]
  key_name                    = "noakirel-keypair"
  associate_public_ip_address = true

  tags = {
    Name  = "BastionHost"
    owner = "meitaveini"
  }
}

resource "aws_eip" "bastion_eip" {
  domain = "vpc"

  tags = {
    Name  = "Bastion-EIP"
    owner = "meitaveini"
  }
}
resource "aws_eip_association" "bastion_eip_assoc" {
  instance_id   = aws_instance.bastion_host.id
  allocation_id = aws_eip.bastion_eip.id
}

# Security Group for private instances
resource "aws_security_group" "private_sg" {
  vpc_id = aws_vpc.main_vpc.id

  ingress {
    from_port       = 22
    to_port         = 22
    protocol        = "tcp"
    security_groups = [aws_security_group.bastion_sg.id] # SSH only from-Bastion
  }

  ingress {
    from_port       = 80
    to_port         = 80
    protocol        = "tcp"
    security_groups = [aws_security_group.lb_sg.id] # connect only from-LB
  }

  ingress {
    from_port       = 9100
    to_port         = 9100
    protocol        = "tcp"
    security_groups = [aws_security_group.monitoring_sg.id] # Prometheus access only
    description     = "Allow Prometheus to scrape node_exporter"
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
  tags = {
    Name  = "private-sg"
    owner = "meitaveini"
  }  
}

# Security Group for Load Balancer
resource "aws_security_group" "lb_sg" {
  vpc_id = aws_vpc.main_vpc.id
  
  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"] 
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

# Load Balancer with 2 subnets
resource "aws_lb" "web_lb" {
  name               = "web-load-balancer"
  internal           = false
  load_balancer_type = "application"
  security_groups    = [aws_security_group.lb_sg.id]

  subnets = [
    aws_subnet.public_subnet_1.id,
    aws_subnet.public_subnet_2.id
  ]
  
  tags = {
    Name  = "WebLoadBalancer"
    owner = "meitaveini"
  }
}

# create Target Group
resource "aws_lb_target_group" "web_tg" {
  name        = "web-target-group"
  port        = 80
  protocol    = "HTTP"
  vpc_id      = aws_vpc.main_vpc.id
  target_type = "instance"
}

resource "aws_lb_listener" "web_listener" {
  load_balancer_arn = aws_lb.web_lb.arn
  port              = 80
  protocol          = "HTTP"

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.web_tg.arn
  }
}

resource "aws_lb_listener" "web_listener_https" {
  load_balancer_arn = aws_lb.web_lb.arn
  port              = 443
  protocol          = "HTTPS"
  ssl_policy        = "ELBSecurityPolicy-2016-08"
  certificate_arn   = aws_acm_certificate.web_cert.arn
  
  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.web_tg.arn
  }
}

# AWS Auto Scaling Group with User Data and Tag Filtering

resource "aws_launch_template" "statuspage_lt" {
  name_prefix   = "statuspage-lt-"
  image_id      = "ami-084568db4383264d4"
  instance_type = "t2.medium"
  key_name      = "noakirel-keypair"
  update_default_version = true

  user_data = filebase64("${path.module}/docs/user-data.sh") 

  vpc_security_group_ids = [aws_security_group.private_sg.id]

  tag_specifications {
    resource_type = "instance"
    tags = {
      Name  = "statuspage-prod"
      owner = "meitaveini"
      role  = "statuspage"
    }
  }
}


resource "aws_autoscaling_group" "statuspage_asg" {
  name                      = "statuspage-asg"
  desired_capacity          = 2
  min_size                  = 2
  max_size                  = 2
  vpc_zone_identifier       = [aws_subnet.private_subnet_1.id, aws_subnet.private_subnet_2.id]
  health_check_type         = "EC2"
  health_check_grace_period = 300
  target_group_arns         = [aws_lb_target_group.web_tg.arn]

  launch_template {
    id      = aws_launch_template.statuspage_lt.id
    version = "$Latest"
  }

  tag {
    key                 = "statuspage-prod"
    value               = "true"
    propagate_at_launch = true
  }

  tag {
    key                 = "owner"
    value               = "meitaveini"
    propagate_at_launch = true
  }

  tag {
    key                 = "role"
    value               = "statuspage"
    propagate_at_launch = true
  }

  lifecycle {
    create_before_destroy = true
  }
}

# Replace your existing monitoring security group with this
resource "aws_security_group" "monitoring_sg_new" {
  name        = "monitoring-sg-new"
  description = "Allow access to Prometheus (9090) and Grafana (3000)"
  vpc_id      = aws_vpc.main_vpc.id

  ingress {
    description     = "SSH"
    from_port       = 22
    to_port         = 22
    protocol        = "tcp"
    security_groups = [aws_security_group.bastion_sg.id] # SSH only from-Bastion
    description     = "SSH access from bastion"
  }
  
  ingress {
    description     = "Grafana Loki-new"
    from_port       = 3100
    to_port         = 3100
    protocol        = "tcp"
    security_groups = [aws_security_group.bastion_sg.id]
  }
  
  ingress {
    description     = "Grafana"
    from_port       = 3000
    to_port         = 3000
    protocol        = "tcp"
    security_groups = [aws_security_group.bastion_sg.id]
  }

  ingress {
    description     = "Prometheus"
    from_port       = 9090
    to_port         = 9090
    protocol        = "tcp"
    security_groups = [aws_security_group.bastion_sg.id]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name  = "monitoring-sg-new"
    owner = "meitaveini"
  }
}

# Update all references to the security group in your private_sg
resource "aws_security_group" "private_sg" {
  # Keep your existing settings
  
  ingress {
    from_port       = 9100
    to_port         = 9100
    protocol        = "tcp"
    security_groups = [aws_security_group.monitoring_sg_new.id] # Updated reference
    description     = "Allow Prometheus to scrape node_exporter"
  }
  
  # Keep other ingress and egress rules
}

# Update your monitoring launch template
resource "aws_launch_template" "monitoring_lt" {
  # Keep your existing settings
  
  vpc_security_group_ids = [aws_security_group.monitoring_sg_new.id]  # Updated reference
  
  # Keep other settings
}

# IAM Role for Prometheus EC2 Service Discovery
resource "aws_iam_role" "prometheus_ec2_discovery" {
  name = "prometheus-ec2-discovery-role"

  assume_role_policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action = "sts:AssumeRole"
        Effect = "Allow"
        Principal = {
          Service = "ec2.amazonaws.com"
        }
      }
    ]
  })

  tags = {
    Name  = "prometheus-ec2-discovery-role"
    owner = "meitaveini"
  }
}

# IAM Policy for EC2 DescribeInstances
resource "aws_iam_policy" "prometheus_ec2_discovery_policy" {
  name        = "prometheus-ec2-describe-policy"
  description = "Allow Prometheus to describe EC2 instances and tags"

  policy = jsonencode({
    Version = "2012-10-17",
    Statement = [
      {
        Effect = "Allow",
        Action = [
          "ec2:DescribeInstances",
          "ec2:DescribeTags",
          "ec2:DescribeRegions"
        ],
        Resource = "*"
      }
    ]
  })
}


# Attach policy to role
resource "aws_iam_role_policy_attachment" "prometheus_ec2_policy_attach" {
  role       = aws_iam_role.prometheus_ec2_discovery.name
  policy_arn = aws_iam_policy.prometheus_ec2_discovery_policy.arn
}

# IAM Instance Profile to assign to EC2
resource "aws_iam_instance_profile" "prometheus_instance_profile" {
  name = "prometheus-instance-profile"
  role = aws_iam_role.prometheus_ec2_discovery.name
}

resource "aws_launch_template" "monitoring_lt" {
  name_prefix   = "monitoring-lt-"
  image_id      = "ami-084568db4383264d4" # Ubuntu 24.04
  instance_type = "t2.medium"
  key_name      = "noakirel-keypair"

  vpc_security_group_ids = [aws_security_group.monitoring_sg.id]
  user_data = filebase64("${path.module}/monitoring/monitoring_user_data.sh")

  iam_instance_profile {
    name = aws_iam_instance_profile.prometheus_instance_profile.name
  }

  tag_specifications {
    resource_type = "instance"
    tags = {
      Name  = "monitoring-node"
      owner = "meitaveini"
      role  = "monitoring"
    }
  }
}

resource "aws_autoscaling_group" "monitoring_asg" {
  name                      = "monitoring-asg"
  desired_capacity          = 1
  min_size                  = 1
  max_size                  = 1
  vpc_zone_identifier       = [aws_subnet.private_subnet_1.id, aws_subnet.private_subnet_2.id]
  health_check_type         = "EC2"
  health_check_grace_period = 300

  launch_template {
    id      = aws_launch_template.monitoring_lt.id
    version = "$Latest"
  }

  tag {
    key                 = "Name"
    value               = "monitoring-node"
    propagate_at_launch = true
  }

  lifecycle {
    create_before_destroy = true
  }
}

# Route 53 Domain Configuration
resource "aws_route53_zone" "primary" {
  name = "noakirelapp.com"
  
  tags = {
    Name  = "Primary-DNS-Zone"
    owner = "meitaveini"
  }
}

# Then add your certificate resources
resource "aws_acm_certificate" "web_cert" {
  domain_name       = "noakirelapp.com"
  validation_method = "DNS"
  subject_alternative_names = ["*.noakirelapp.com"]
  
  tags = {
    Name  = "noakirelapp-cert"
    owner = "meitaveini"
  }
  
  lifecycle {
    create_before_destroy = true
  }
}

# Certificate validation via DNS
resource "aws_route53_record" "cert_validation" {
  for_each = {
    for dvo in aws_acm_certificate.web_cert.domain_validation_options : dvo.domain_name => {
      name   = dvo.resource_record_name
      record = dvo.resource_record_value
      type   = dvo.resource_record_type
    }
  }
  
  zone_id = aws_route53_zone.primary.zone_id
  name    = each.value.name
  type    = each.value.type
  records = [each.value.record]
  ttl     = 60
}

resource "aws_acm_certificate_validation" "cert" {
  certificate_arn         = aws_acm_certificate.web_cert.arn
  validation_record_fqdns = [for record in aws_route53_record.cert_validation : record.fqdn]
}

# Update your load balancer security group to allow HTTPS
resource "aws_security_group_rule" "lb_https_inbound" {
  type              = "ingress"
  from_port         = 443
  to_port           = 443
  protocol          = "tcp"
  cidr_blocks       = ["0.0.0.0/0"]
  security_group_id = aws_security_group.lb_sg.id
}

# Then uncomment and update your HTTPS listener
resource "aws_lb_listener" "web_listener_https" {
  load_balancer_arn = aws_lb.web_lb.arn
  port              = 443
  protocol          = "HTTPS"
  ssl_policy        = "ELBSecurityPolicy-2016-08"
  certificate_arn   = aws_acm_certificate.web_cert.arn

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.web_tg.arn
  }
}

# Add Route 53 records pointing to your load balancer
resource "aws_route53_record" "www" {
  zone_id = aws_route53_zone.primary.zone_id
  name    = "www.noakirelapp.com"
  type    = "A"

  alias {
    name                   = aws_lb.web_lb.dns_name
    zone_id                = aws_lb.web_lb.zone_id
    evaluate_target_health = true
  }
}

# Root domain record
resource "aws_route53_record" "root" {
  zone_id = aws_route53_zone.primary.zone_id
  name    = "noakirelapp.com"
  type    = "A"

  alias {
    name                   = aws_lb.web_lb.dns_name
    zone_id                = aws_lb.web_lb.zone_id
    evaluate_target_health = true
  }
}