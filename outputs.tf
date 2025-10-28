output "bastion_public_ip" {
  description = "Public IP of the Bastion Host"
  value       = aws_instance.bastion_host.public_ip
}

output "load_balancer_dns" {
  description = "DNS name of the Load Balancer"
  value       = aws_lb.web_lb.dns_name
}

