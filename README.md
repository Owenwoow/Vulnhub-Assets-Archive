<div align="center">
  <h1>🛡️ Vulnhub-Assets-Archive</h1>
  <p>
    <b>An archive of source code and raw assets extracted from Vulnhub vulnerable machines,<br>alongside AI-assisted security analysis and workspace records.</b>
  </p>
  <p>
    <img src="https://img.shields.io/badge/Security-Research-blue.svg" alt="Security Research">
    <img src="https://img.shields.io/badge/Platform-Vulnhub-orange.svg" alt="Vulnhub">
    <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
  </p>
</div>

<br>

## 🎯 关于本项目 (About)

本项目是个人网络安全打靶（主要针对 **Vulnhub** 平台靶机）的资产归档库。主要目的是沉淀靶机环境的原始源码、实战渗透过程中的测试脚本，以及利用 **AI 辅助审计** 的核心漏洞代码笔记。

---

## 🗂️ 目录规范 (Repository Structure)

为了保持仓库的高效与整洁，每个靶机均采用**极简二元法则**结构：

> **`[靶机名]_raw.[后缀]`** —— **官方原始资产**
> 直接从靶机系统中提取的原始系统文件、Web源码等（未做任何修改）。

> **`workspace/`** —— **测试工作区**
> 包含在打靶过程中产生的所有个人记录，如：
> - 📡 **扫描记录** (Nmap, Dirb, Gobuster 等)
> - ⚔️ **利用脚本** (提权或 RCE 漏洞的 Exploits)
> - 🤖 **AI 审计代码** (经过 AI 深度分析并添加详细注释的关键漏洞源码，通常命名为 `*_ai_annotated.*`)

*📝 注：每个靶机根目录下的单独 `README.md` 仅作为元数据，用于记录该靶机的官方下载链接及原始压缩包的 MD5 校验值。*

---

## 🤖 自动化管理工作流

本仓库集成了 **AI 自动化整理工作流**。核心规范定义于 `.repo_rules/auto_organize.prompt.md`。每次引入新文件后，配合 AI 助手即可实现一键归类、重命名与自动 Commit，极大地提升了归档效率。

---

## ⚠️ 免责声明 (Disclaimer)

> [!WARNING]
> This repository is for educational and security research purposes only. The raw assets extracted from Vulnhub machines belong to their respective original authors. Any exploit scripts or techniques demonstrated here should only be used in authorized testing environments.
> 
> *(本仓库仅供教育和安全研究使用。从 Vulnhub 靶机中提取的原始资产归其各自的原作者所有。严禁将本仓库相关技术用于任何未经授权的非法用途。)*
