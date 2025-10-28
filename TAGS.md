# 📘 TAGS.md – AWS EC2 Tagging Structure for Status Page Deployment

This document describes the tagging structure used for AWS EC2 instances to enable automatic deployment (CD) via GitHub Actions.

---

## 🧭 Purpose
Tags are used to identify which servers should receive automatic updates upon a `push` to the `main` branch or during manual deployment via GitHub.

---

## 🏷️ Tags in Use

### 1. `Name`
- **Value**: `statuspage-prod`
- **Description**: Identifies the server as part of the production Status Page system.

### 2. `owner`
- **Value**: `statuspage-team`
- **Description**: Indicates the person responsible for the server (for maintenance, monitoring, and ownership).

### (Optional) Recommended Tags for Future Use:

| Tag    | Example Value | Purpose                                 |
|--------|----------------|-----------------------------------------|
| `env`  | `production`   | Marks the environment type             |
| `role` | `web`          | Defines the server role (web, db, etc.)|
| `team` | `devops`       | Associates the server with a team      |

---

## 🧪 How Tags Work with GitHub Actions
In the `.github/workflows/deploy.yml` file, there's a step that runs:
```bash
aws ec2 describe-instances \
  --filters "Name=tag:Name,Values=statuspage-prod" "Name=tag:owner,Values=statuspage-team"
```
Only instances that match **both** conditions will receive the deployment.

---

## 📌 Ensure That:
- Every Auto Scaling Launch Template includes these tags.
- Any other project using similar deployment logic adopts this tagging structure.

---

Good luck! ☁️🚀
